<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $query = Transaction::query();

        if ($request->filled('category')){
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('type')){
            $query->where('type', $request->type);
        }

        if ($request->filled('period')) {
            [$ano, $mes] = explode('-', $request->period);
            
            $query->whereYear('created_at', $ano)
                ->whereMonth('created_at', $mes);
        }

        $transactions = $query->where('user_id', Auth::user()->id)->paginate(25);

        $categories = Category::where('user_id', Auth::user()->id)->get();

        return view('transactions.index', compact('transactions', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        $categories = Category::where('user_id', Auth::user()->id)->get();
        return view('transactions.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Primeiro, limpa e converte o valor antes da validação
        $cleanValue = $this->cleanCurrencyValue($request->input('value'));
        $request->merge(['value' => $cleanValue]);

        $request->validate([
            'category_id' => 'required|integer|exists:categories,id',
            'type' => 'required|string|in:income,expense',
            'value' => 'required|numeric',
            'date' => 'required|date',
            'description' => 'required|string|max:255',
        ]);

        $transaction = new Transaction();
        $transaction->category_id = $request->input('category_id');
        $transaction->user_id = $request->input('user_id');
        $transaction->type = $request->input('type');
        $transaction->value = $request->input('value');
        $transaction->date = $request->input('date');
        $transaction->description = $request->input('description');
        $transaction->save();

        return redirect()->route('transactions.index')->with('success', 'Transação registrada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $transaction = Transaction::with('category')->findOrFail($id);

        return view('transactions.show',compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $transaction = Transaction::with('category')->findOrFail($id);

        $categories = Category::where('user_id', Auth::user()->id)->get();

        return view('transactions.edit',compact('transaction', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Primeiro, limpa e converte o valor antes da validação
        $cleanValue = $this->cleanCurrencyValue($request->input('value'));
        $request->merge(['value' => $cleanValue]);

        $request->validate([
            'category_id' => 'required|integer|exists:categories,id',
            'type' => 'required|string|in:income,expense',
            'value' => 'required|numeric',
            'date' => 'required|date',
            'description' => 'required|string|max:255',
        ]);

        $transaction = Transaction::findOrFail($id);
        $transaction->category_id = $request->input('category_id');
        $transaction->type = $request->input('type');
        $transaction->value = $request->input('value');
        $transaction->date = $request->input('date');
        $transaction->description = $request->input('description');
        $transaction->save();

        return redirect()->route('transactions.index')->with('success', 'Transação atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();

        return redirect()->route('transactions.index')->with('success', 'Transação excluída com sucesso!');
    }

    private function cleanCurrencyValue($value)
    {
        // Remove 'R$ ', pontos (separadores de milhares) e substitui vírgula por ponto
        $cleanValue = str_replace(['R$ ', '.'], '', $value);
        $cleanValue = str_replace(',', '.', $cleanValue);
        
        return floatval($cleanValue);
    }
}
