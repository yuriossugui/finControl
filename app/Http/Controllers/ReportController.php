<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Category;
use App\Models\Goal;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $transactionsQuery = Transaction::query();

        $categoriesQuery = Category::query()
            ->selectRaw('categories.name, SUM(transactions.value) as total')
            ->join('transactions', 'categories.id', '=', 'transactions.category_id')
            ->groupBy('categories.name')
        ;

        $goalsQuery = Goal::with('category')->where('user_id', Auth::user()->id)->paginate(15); 

        if($request->filled('category')){
            $transactionsQuery->where('category_id', $request->category);
            $categoriesQuery->where('categories.id', $request->category);
            $goalsQuery->where('category_id', $request->category);
        }

        if($request->filled('start_date') && $request->filled('end_date')){
            $transactionsQuery->whereBetween('date', [$request->start_date, $request->end_date]);
            $categoriesQuery->whereBetween('transactions.date', [$request->start_date, $request->end_date]);
            $goalsQuery->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }else{
            $startOfMonth = Carbon::now()->startOfMonth();
            $endOfMonth = Carbon::now()->endOfMonth();
            $transactionsQuery->whereBetween('date', [$startOfMonth, $endOfMonth]);
            $categoriesQuery->whereBetween('transactions.date', [$startOfMonth, $endOfMonth]);
            $goalsQuery->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
        }

        $transactionsQuery->where('user_id', Auth::user()->id);

        $categoriesQuery->where('transactions.user_id', Auth::user()->id);

        $transactionsList = $transactionsQuery->paginate(10);

        $categoriesList = $categoriesQuery->paginate(15);

        $total_income = $transactionsQuery->where('type', 'income')->sum('value');
        
        $total_expense = $transactionsQuery->where('type', 'expense')->sum('value');

        $current_balance = $total_income - $total_expense;
        
        $transactionsChartData = Transaction::query()
            ->selectRaw("
                CASE 
                    WHEN type = 'income' THEN 'Receita'
                    WHEN type = 'expense' THEN 'Despesa'
                    ELSE type
                END as label, 
                SUM(value) as total
            ")
            ->where('user_id', Auth::user()->id)
            ->whereNull('deleted_at')
            ->when($request->filled('category'), function ($query) use ($request) {
                $query->where('category_id', $request->category);
            })
            ->when($request->filled('start_date') && $request->filled('end_date'), function ($query) use ($request) {
                $query->whereBetween('date', [$request->start_date, $request->end_date]);
            }, function ($query) {
                $startOfMonth = Carbon::now()->startOfMonth();
                $endOfMonth = Carbon::now()->endOfMonth();
                $query->whereBetween('date', [$startOfMonth, $endOfMonth]);
            })
            ->groupBy('label')
            ->get()
        ;

        $transactions = (object) [
            'total_income' => $total_income,
            'total_expense' => $total_expense,
            'current_balance' => $current_balance,
            'chart_data' => [
                'labels' => $transactionsChartData->pluck('label'),
                'data' => $transactionsChartData->pluck('total'),
            ]
        ];

        $categories = (object) [
            'list' => $categoriesList,
            'chartData' => [
                'labels' => $categoriesList->pluck('name'),
                'data' => $categoriesList->pluck('total'),
            ]
        ];

        $goals = (object) [
            'list' => $goalsQuery,
            'chartData' => [
                'labels' => $goalsQuery->pluck('category.name'),
                'data' => $goalsQuery->pluck('progress'),
            ]
        ];

        $filterCategories = Category::where('user_id', Auth::user()->id)->get();

        return view('reports.index', compact('transactions', 'transactionsList', 'filterCategories', 'categories', 'goals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
