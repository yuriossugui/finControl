@extends('layouts.app')

@section('title', 'Categorias')

@section('content')
    <div class="d-flex justify-content-center">
        <h2>Adicionar Categoria</h2>
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

        <form action="{{ route('category.store') }}" method="post">
            @csrf
            <div class="row mb-2">
    
                <div class="col">
                    
                    <div class="input-group">
                        <span class="input-group-text"><ion-icon name="pricetag"></ion-icon></span>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Nome da Categoria" required>
                    </div>
    
                </div>
    
                <div class="col">
                    
                    <div class="input-group">
                        <label for="type" class="input-group-text"><ion-icon name="list"></ion-icon></label>
                        <select class="form-select" name="type" id="type">
                            <option value="" selected>Escolha o Tipo da Categoria</option>
                            <option value="income">Receita</option>
                            <option value="expense">Despesa</option>
                        </select>
                    </div>
    
                </div>
    
            </div>
    
            <div class="row mb-2">
    
                <div class="col-1">
    
                    <div class="input-group">
                        <span class="input-group-text"><ion-icon name="color-fill"></ion-icon></span>
                        <input type="color" class="form-control" name="color" id="color" placeholder="Cor da Categoria" required>
                    </div>
    
                </div>
    
            </div>
    
            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
    
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-success">Salvar Categoria</button>
            </div>
    
        </form>

    </div>
@endsection
