@extends('layouts.app')

@section('title', 'Transações')

@section('content')

    <link rel="stylesheet" href="{{ asset('css/transactionsShow.css') }}">

    <div class="container my-4">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="mb-0 fw-bold">
                                <ion-icon name="cash" class="text-success me-2"></ion-icon>
                                Detalhes da Transação
                            </h4>
                            <a href="{{ route('transactions.index') }}" class="btn btn-light btn-sm">
                                <ion-icon name="arrow-back"></ion-icon> Voltar
                            </a>
                        </div>

                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between">
                                <span><ion-icon name="pricetag" class="text-primary me-2"></ion-icon>Categoria</span>
                                <span class="fw-semibold">{{ $transaction->category->name ?? 'N/A' }}</span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between">
                                <span><ion-icon name="person" class="text-secondary me-2"></ion-icon>Usuário</span>
                                <span class="fw-semibold">{{ $transaction->user->name ?? 'N/A' }}</span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between">
                                <span><ion-icon name="swap" class="text-info me-2"></ion-icon>Tipo</span>
                                <span class="fw-semibold text-uppercase">
                                    <span class="{{ $transaction->type === 'income' ? 'text-success' : 'text-danger' }}">
                                        {{ $transaction->type == 'income' ? 'Receita' : 'Despesa' }}
                                    </span>
                                </span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between">
                                <span><ion-icon name="calendar" class="text-warning me-2"></ion-icon>Data</span>
                                <span>{{ \Carbon\Carbon::parse($transaction->date)->format('d/m/Y') }}</span>
                            </li>

                            <li class="list-group-item d-flex justify-content-between">
                                <span><ion-icon name="wallet" class="text-success me-2"></ion-icon>Valor</span>
                                <span class="fw-bold fs-5 text-success">
                                    R$ {{ number_format($transaction->value, 2, ',', '.') }}
                                </span>
                            </li>

                            <li class="list-group-item">
                                <ion-icon name="document-text" class="text-muted me-2"></ion-icon>
                                <strong>Descrição:</strong>
                                <p class="mt-2 mb-0">{{ $transaction->description ?? 'Sem descrição.' }}</p>
                            </li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
