@extends('layouts.app')

@section('title', 'Transações')

@section('content')
    <div class="d-flex justify-content-center">
        <h2>Adicionar Transação</h2>
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

        <form action="#" method="post">
            @csrf
            
            <div class="row">

                <div class="col">
                    <div class="input-group">
                        <label for="category_id" class="input-group-text"><ion-icon name="list"></ion-icon></label>
                        <select class="form-select" name="category_id" id="category_id">
                            <option value="" selected>Escolha a Categoria</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col">
                    <div class="input-group">
                        <label for="type" class="input-group-text"><ion-icon name="list"></ion-icon></label>
                        <select class="form-select" name="type" id="type">
                            <option value="" selected>Escolha o Tipo da Transação</option>
                            <option value="income">Receita</option>
                            <option value="expense">Despesa</option>
                        </select>
                    </div>
                </div>

            </div>

        </form>

    </div>
@endsection
