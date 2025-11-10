@extends('layouts.app')

@section('title', 'Categorias')

@section('content')

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-start mb-2">
        <a href="{{ route('category.create') }}" class="btn btn-primary">Adicionar Categoria</a>
    </div>

    <div class="d-flex justify-content-center">
        <table class="table table-bordered">
            <thead class="text-center">
                <tr>
                    <th>Nome</th>
                    <th>Tipo</th>
                    <th>Cor</th>
                    <th>Editar</th>
                    <th>Excluir</th>
                </tr>
            </thead>
            <tbody class="text-center">
                @foreach($categories as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td>
                            @if($category->type == 'income')
                                Receita
                            @elseif($category->type == 'expense')
                                Despesa
                            @endif
                        </td>
                        <td><ion-icon name="square" size="large" style="color: {{ $category->color }};"></ion-icon></td>
                        <td>
                            <a href="{{ route('category.edit', $category->id) }}"><button class="btn btn-warning">Editar</button></a>
                        </td>
                        <td>
                            <form action="{{ route('category.destroy', $category->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="id" value="{{ $category->id }}">
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir esta categoria?')">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>
@endsection
