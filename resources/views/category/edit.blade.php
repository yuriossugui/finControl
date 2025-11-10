@extends('layouts.app')

@section('title', 'Categorias')

@section('content')
    <div class="d-flex justify-content-center">
        <h2>Editar Categoria</h2>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card p-2">
        
        <form action="{{ route('category.update', $category->id) }}" method="post">
            @csrf
            @method('PUT')
            <div class="row mb-2">
    
                <div class="col">
                    
                    <div class="input-group">
                        <span class="input-group-text"><ion-icon name="pricetag"></ion-icon></span>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Nome da Categoria" value="{{ $category->name }}" required>
                    </div>
    
                </div>
    
                <div class="col">
                    
                    <div class="input-group">
                        <label for="type" class="input-group-text"><ion-icon name="list"></ion-icon></label>
                        <select class="form-select" name="type"  id="type">
                            <option value="">Escolha o Tipo da Categoria</option>
                            <option value="income" {{ $category->type == 'income' ? 'selected' : '' }}>Receita</option>
                            <option value="expense" {{ $category->type == 'expense' ? 'selected' : '' }}>Despesa</option>
                        </select>
                    </div>
    
                </div>
    
            </div>
    
            <div class="row mb-2">
    
                <div class="col-1">
    
                    <div class="input-group">
                        <span class="input-group-text"><ion-icon name="color-fill"></ion-icon></span>
                        <input type="color" class="form-control" name="color" id="color" placeholder="Cor da Categoria" value="{{ $category->color }}" required>
                    </div>
    
                </div>
    
            </div>
    
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-success">Atualizar Categoria</button>
            </div>
    
        </form>

    </div>
@endsection
