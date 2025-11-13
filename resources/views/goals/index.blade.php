@extends('layouts.app')

@section('title', 'Metas')

@section('content')

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <link rel="stylesheet" href="{{ asset('css/transactionsIndex.css') }}">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <a href="{{ route('goals.create') }}" class="btn btn-primary">Adicionar Meta</a>
        
        <div class="filters">
            <form action="" method="get" class="d-flex align-items-center gap-2">

                <label class="nowrap-label" for="category">Pesquisar Categoria</label>
                <select class="form-control" name="category" id="category">
                    <option value="" selected>Selecione uma Categoria</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>

                <label class="nowrap-label" for="start_date">Pesquisar Período</label>
                <input class="form-control" type="date" name="start_date" id="start_date">

                <label class="nowrap-label" for="end_date">até</label>
                <input class="form-control" type="date" name="end_date" id="end_date">

                <button type="submit" class="btn btn-primary"><ion-icon name="search"></ion-icon></button>
            </form>
        </div>
    </div>

    <div class="d-flex justify-content-center">
        <table class="table table-bordered">
            <thead class="text-center">
                <tr>
                    <th>Categoria</th>
                    <th>Meta</th>
                    <th>Progresso</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @foreach($goals as $goal)
                    <tr>
                        <td>{{ $goal->category->name }}</td>
                        <td>R$ {{ number_format($goal->target_value, 2, ',', '.') }}</td>
                        <td>
                            {{ number_format($goal->progress, 2) }}%
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped bg-info progress-bar-animated" role="progressbar" style="width: {{ $goal->progress }}%" aria-valuenow="{{ $goal->progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </td>
                        <td>
                            <a href="{{ route('goals.show', $goal->id) }}" class="btn btn-sm btn-info"><ion-icon name="eye"></ion-icon></a>
                            <a href="{{ route('goals.edit', $goal->id) }}" class="btn btn-sm btn-warning"><ion-icon name="create"></ion-icon></a>
                            <form action="{{ route('goals.destroy', $goal->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta meta?')">
                                    <ion-icon name="trash"></ion-icon>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $goals->links() }}
@endsection
