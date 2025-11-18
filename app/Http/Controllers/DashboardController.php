<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Transaction;
use App\Models\Category;
use App\Models\Goal;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::user()->id;

        // Mês atual
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $categoriesList = Transaction::with('category')
            ->where('user_id', $userId)
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->get()
            ->groupBy(function ($transaction) {
                return $transaction->category->name;
            });

        $incomeTransactionsByCategory = Transaction::with('category')
            ->where('type', 'income')
            ->where('user_id', $userId)
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->sum('value');

        $expenseTransactionsByCategory = Transaction::with('category')
            ->where('type', 'expense')
            ->where('user_id', $userId)
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->sum('value');

        $monthlyChartDataLabels = Transaction::selectRaw('EXTRACT(MONTH FROM date) as month')
            ->where('user_id', $userId)
            ->whereNull('deleted_at')
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('month')
            ->toArray();

        $totalIncome = Transaction::where('user_id', $userId)
            ->where('type', 'income')
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->sum('value');

        $totalExpense = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->sum('value');

        $currentBalance = $totalIncome - $totalExpense;

        // Mês passado
        $startOfLastMonth = Carbon::now()->subMonth()->startOfMonth();
        $endOfLastMonth = Carbon::now()->subMonth()->endOfMonth();

        $lastMonthIncome = Transaction::where('user_id', $userId)
            ->where('type', 'income')
            ->whereBetween('date', [$startOfLastMonth, $endOfLastMonth])
            ->sum('value');

        $lastMonthExpense = Transaction::where('user_id', $userId)
            ->where('type', 'expense')
            ->whereBetween('date', [$startOfLastMonth, $endOfLastMonth])
            ->sum('value');

        $lastMonthBalance = $lastMonthIncome - $lastMonthExpense;

        if ($lastMonthBalance != 0 && $lastMonthIncome != 0 && $lastMonthExpense != 0) {
            $balanceVariation = (($currentBalance - $lastMonthBalance) / abs($lastMonthBalance)) * 100;
            $incomeVariation = (($totalIncome - $lastMonthIncome) / abs($lastMonthIncome)) * 100;
            $expenseVariation = (($totalExpense - $lastMonthExpense) / abs($lastMonthExpense)) * 100;
        } else {
            $balanceVariation = 0;
            $incomeVariation = 0;
            $expenseVariation = 0;
        }

        $monthlyChartData = (object) [
            'labels' => $monthlyChartDataLabels,
            'income' => $incomeTransactionsByCategory,
            'expense' => $expenseTransactionsByCategory,
        ];

        $categoryChartData = (object) [
            'labels' => [],
            'totals' => [],
            'colors' => [],
        ];

        foreach ($categoriesList as $categoryName => $transactions) {
            $categoryChartData->labels[] = $categoryName;
            $categoryChartData->totals[] = $transactions->sum('value');
            $categoryChartData->colors[] = $transactions->first()->category->color ?? '#000000';
        }

        return view('dashboard.index', 
        compact(
            'totalIncome', 'totalExpense', 'currentBalance',
            'lastMonthIncome', 'lastMonthExpense', 'lastMonthBalance', 
            'balanceVariation', 'incomeVariation', 'expenseVariation',
            'categoriesList', 'monthlyChartData', 'categoryChartData'
        ));
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
