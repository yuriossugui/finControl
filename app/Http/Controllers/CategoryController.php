<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $categories = Category::where('user_id', '=', Auth::user()->id)
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%');
            })->get();

        return view('category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:income,expense',
            'color' => 'required|string|max:7',
        ]);

        $category = new Category();
        $category->name = $request->input('name');
        $category->type = $request->input('type');
        $category->color = $request->input('color');
        $category->user_id = $request->input('user_id');
        $category->save();

        return redirect()->route('category.index')->with('success', 'Categoria criada com sucesso!');
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
        $category = Category::findOrFail($id);
        return view('category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:income,expense',
            'color' => 'required|string|max:7',
        ]);

        $category = Category::findOrFail($id);
        $category->name = $request->input('name');
        $category->type = $request->input('type');
        $category->color = $request->input('color');
        $category->save();

        return redirect()->route('category.index')->with('success', 'Categoria atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('category.index')->with('success', 'Categoria excluída com sucesso!');
    }
}
