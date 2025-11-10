@extends('layouts.app')

@section('title', 'Transações')

@section('content')

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-between mb-2">
        <a href="{{ route('transactions.create') }}" class="btn btn-primary">Adicionar Transação</a>
        <div>
            <form action="" method="get">
                <input type="text" name="search" id="search" placeholder="Pesquisar Categoria" class="form-control d-inline-block" style="width: auto;">
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
                    <th>Descricao</th>
                    <th>Categoria</th>
                    <th>Editar</th>
                    <th>Excluir</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
