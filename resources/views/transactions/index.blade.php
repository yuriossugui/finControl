@extends('layouts.app')

@section('title', 'Transações')

@section('content')

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <link rel="stylesheet" href="{{ asset('css/transactionsIndex.css') }}">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <a href="{{ route('transactions.create') }}" class="btn btn-primary">Adicionar Transação</a>
        
        <div class="filters">
            <form action="" method="get" class="d-flex align-items-center gap-2">

                <label class="nowrap-label" for="category">Pesquisar Categoria</label>
                <select class="form-control" name="category" id="category">
                    <option value="" selected>Selecione uma Categoria</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>

                <label class="nowrap-label" for="type">Pesquisar Tipo</label>
                <select class="form-control" name="type" id="type">
                    <option value="" selected>Pesquisar por Tipos</option>
                    <option value="income">Receita</option>
                    <option value="expense">Despesa</option>
                </select>

                <label class="nowrap-label" for="period">Pesquisar Período</label>
                <input class="form-control" type="month" name="period" id="period">

                <button type="submit" class="btn btn-primary"><ion-icon name="search"></ion-icon></button>
            </form>
        </div>
    </div>

    <div class="d-flex justify-content-center">
        <table class="table table-bordered">
            <thead class="text-center">
                <tr>
                    <th>Tipo</th>
                    <th>Data</th>
                    <th>Valor</th>
                    <th>Categoria</th>
                    <th colspan="3">Ações</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @foreach($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->type == 'income' ? 'Receita' : 'Despesa' }}</td>
                        <td>{{ \Carbon\Carbon::parse($transaction->date)->format('d/m/Y') }}</td>
                        <td>R$ {{ number_format($transaction->value, 2, ',', '.') }}</td>
                        <td>{{ $transaction->category->name }}</td>
                        <td>
                            <a href="{{  route('transactions.show', $transaction->id)  }}">
                                <button class="btn btn-info">Ver</button>
                            </a>
                        </td>
                        <td>
                            <a href="{{  route('transactions.edit', $transaction->id)  }}">
                                <button class="btn btn-warning">Editar</button>
                            </a>
                        </td>
                        <td>
                            <form action="{{ route('transactions.destroy', $transaction->id) }}" method="post" onsubmit="return confirm('Tem certeza que deseja excluir esta transação?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $transactions->links() }}
@endsection
