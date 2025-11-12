@extends('layouts.app')

@section('title', 'Editar Transação')

@section('content')

    <link rel="stylesheet" href="{{ asset('css/transactionsEdit.css') }}">

    <div class="container my-4">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body p-4">

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="mb-0 fw-bold">
                                <ion-icon name="create" class="text-primary me-2"></ion-icon>
                                Editar Transação
                            </h4>
                            <a href="{{ route('transactions.show', $transaction->id) }}" class="btn btn-light btn-sm">
                                <ion-icon name="arrow-back"></ion-icon> Voltar
                            </a>
                        </div>

                        {{-- Mensagem de erro --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Formulário de edição --}}
                        <form action="{{ route('transactions.update', $transaction->id) }}" method="POST" class="needs-validation" novalidate>
                            @csrf
                            @method('PUT')

                            {{-- Categoria --}}
                            <div class="mb-3">
                                <label for="category_id" class="form-label">
                                    <ion-icon name="pricetag" class="text-primary me-1"></ion-icon>
                                    Categoria
                                </label>
                                <select name="category_id" id="category_id" class="form-select" required>
                                    <option value="">Selecione uma categoria</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" 
                                            {{ $transaction->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Tipo --}}
                            <div class="mb-3">
                                <label for="type" class="form-label">
                                    <ion-icon name="swap" class="text-info me-1"></ion-icon>
                                    Tipo
                                </label>
                                <select name="type" id="type" class="form-select" required>
                                    <option value="income" {{ $transaction->type === 'income' ? 'selected' : '' }}>Receita</option>
                                    <option value="expense" {{ $transaction->type === 'expense' ? 'selected' : '' }}>Despesa</option>
                                </select>
                            </div>

                            {{-- Valor --}}
                            <div class="mb-3">
                                <label for="value" class="form-label">
                                    <ion-icon name="wallet" class="text-success me-1"></ion-icon>
                                    Valor
                                </label>
                                <input 
                                    type="text" 
                                    name="value" 
                                    id="value" 
                                    class="form-control" 
                                    value="{{ old('value', $transaction->value) }}" 
                                    required>
                            </div>

                            {{-- Data --}}
                            <div class="mb-3">
                                <label for="date" class="form-label">
                                    <ion-icon name="calendar" class="text-warning me-1"></ion-icon>
                                    Data
                                </label>
                                <input 
                                    type="date" 
                                    name="date" 
                                    id="date" 
                                    class="form-control" 
                                    value="{{ old('date', \Carbon\Carbon::parse($transaction->date)->format('Y-m-d')) }}" 
                                    required>
                            </div>

                            {{-- Descrição --}}
                            <div class="mb-3">
                                <label for="description" class="form-label">
                                    <ion-icon name="document-text" class="text-muted me-1"></ion-icon>
                                    Descrição
                                </label>
                                <textarea 
                                    name="description" 
                                    id="description" 
                                    rows="3" 
                                    class="form-control" 
                                    placeholder="Adicione uma descrição opcional...">{{ old('description', $transaction->description) }}</textarea>
                            </div>

                            {{-- Botões --}}
                            <div class="d-flex justify-content-end mt-4">
                                <button type="submit" class="btn btn-primary me-2">
                                    <ion-icon name="save-outline"></ion-icon> Salvar Alterações
                                </button>
                                <a href="{{ route('transactions.show', $transaction->id) }}" class="btn btn-outline-secondary">
                                    <ion-icon name="close-circle-outline"></ion-icon> Cancelar
                                </a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/createTransaction.js') }}"></script>

@endsection
