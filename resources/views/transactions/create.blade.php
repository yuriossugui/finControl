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

        <form action="{{ route('transactions.store') }}" method="post">
            @csrf
            
            <div class="row mb-2">

                <div class="col">
                    <div class="input-group">
                        <label for="category_id" class="input-group-text"><ion-icon name="list"></ion-icon></label>
                        <select class="form-select" name="category_id" id="category_id" required>
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
                        <select class="form-select" name="type" id="type" required>
                            <option value="" selected>Escolha o Tipo da Transação</option>
                            <option value="income">Receita</option>
                            <option value="expense">Despesa</option>
                        </select>
                    </div>
                </div>

            </div>

            <div class="row mb-2">
                
                <div class="col">
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1"><ion-icon name="cash"></ion-icon></span>
                        <input type="text" class="form-control" name="value" id="value" placeholder="Valor da Transação (R$)" aria-label="Valor da Transação" aria-describedby="basic-addon1">
                    </div>
                </div>

                <div class="col">
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1"><ion-icon name="calendar"></ion-icon></span>
                        <input type="date" class="form-control" name="date" placeholder="Data da Transação" aria-label="Data da Transação" aria-describedby="basic-addon1">
                    </div>
                </div>

            </div>

            <div class="row mb-2">

                <div class="col">
                    <div class="input-group">
                        <textarea class="form-control" id="description" name="description" placeholder="Descrição da Transação" rows="3"></textarea>
                    </div>
                </div>

            </div>

            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary">Registrar Transação</button>
            </div>

        </form>

    </div>

    <script src="{{ asset('js/createTransaction.js') }}"></script>
@endsection
