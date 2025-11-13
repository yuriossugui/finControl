<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Goal;
use App\Models\Category;
use Carbon\Carbon;

class GoalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Goal::query();

        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        if($request->filled('category')){
            $query->where('category_id', $request->category);
        }

        if($request->filled('start_date') && $request->filled('end_date')){
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);    
        }else{
            $query->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
        }

        $query->where('user_id', Auth::user()->id);

        $goals = $query->with('category')->paginate(25);

        $categories = Category::where('user_id', Auth::user()->id)->get();

        return view('goals.index', compact('goals', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('user_id', Auth::user()->id)->get();

        return view('goals.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Primeiro, limpa e converte o valor antes da validação
        $cleanTargetValue = $this->cleanCurrencyValue($request->input('target_value'));
        $cleanCurrentValue = $this->cleanCurrencyValue($request->input('current_value'));
        $request->merge(['target_value' => $cleanTargetValue, 'current_value' => $cleanCurrentValue]);

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'target_value' => 'required|numeric|min:0',
            'current_value' => 'required|numeric|min:0',
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2025|max:2100',
        ]);

        $goal = new Goal();
        $goal->user_id = Auth::user()->id;
        $goal->category_id = $request->input('category_id');
        $goal->target_value = $request->input('target_value');
        $goal->current_value = $request->input('current_value');
        $goal->month = $request->input('month');
        $goal->year = $request->input('year');
        $goal->save();

        return redirect()->route('goals.index')->with('success', 'Meta adicionada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $goal = Goal::with('category')->findOrFail($id);
        return view('goals.show', compact('goal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $goal = Goal::with('category')->findOrFail($id);
        $categories = Category::where('user_id', Auth::user()->id)->get();

        return view('goals.edit', compact('goal', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Primeiro, limpa e converte o valor antes da validação
        $cleanTargetValue = $this->cleanCurrencyValue($request->input('target_value'));
        $cleanCurrentValue = $this->cleanCurrencyValue($request->input('current_value'));
        $request->merge(['target_value' => $cleanTargetValue, 'current_value' => $cleanCurrentValue]);

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'target_value' => 'required|numeric|min:0',
            'current_value' => 'required|numeric|min:0',
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2025|max:2100',
        ]);

        $goal = Goal::findOrFail($id);
        $goal->category_id = $request->input('category_id');
        $goal->target_value = $request->input('target_value');
        $goal->current_value = $request->input('current_value');
        $goal->month = $request->input('month');
        $goal->year = $request->input('year');
        $goal->save();

        return redirect()->route('goals.index')->with('success', 'Meta atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    private function cleanCurrencyValue($value)
    {
        // Remove 'R$ ', pontos (separadores de milhares) e substitui vírgula por ponto
        $cleanValue = str_replace(['R$ ', '.'], '', $value);
        $cleanValue = str_replace(',', '.', $cleanValue);
        
        return floatval($cleanValue);
    }
}
