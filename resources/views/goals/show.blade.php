@extends('layouts.app')

@section('title', 'Detalhes da Meta')

@section('content')
<div class="container my-4">

    {{-- Título --}}
    <div class="d-flex justify-content-center mb-3">
        <h2>
            <ion-icon name="flag-outline" class="me-2"></ion-icon>
            Detalhes da Meta
        </h2>
    </div>

    {{-- Cartão principal --}}
    <div class="card shadow-sm border-0 rounded-4 p-4">
        <div class="row g-3">
            {{-- Categoria --}}
            <div class="col-md-6">
                <div class="d-flex align-items-center">
                    <ion-icon name="list-outline" class="text-primary fs-4 me-2"></ion-icon>
                    <div>
                        <small class="text-muted">Categoria</small>
                        <h5 class="mb-0">{{ $goal->category->name ?? 'Sem categoria' }}</h5>
                    </div>
                </div>
            </div>

            {{-- Mês e Ano --}}
            <div class="col-md-6">
                <div class="d-flex align-items-center">
                    <ion-icon name="calendar-outline" class="text-primary fs-4 me-2"></ion-icon>
                    <div>
                        <small class="text-muted">Período</small>
                        <h5 class="mb-0">
                            {{ $goal->month }}/{{ $goal->year }}
                        </h5>
                    </div>
                </div>
            </div>
        </div>

        <hr class="my-4">

        {{-- Valores --}}
        <div class="row g-3">
            <div class="col-md-6">
                <div class="d-flex align-items-center">
                    <ion-icon name="cash-outline" class="text-success fs-4 me-2"></ion-icon>
                    <div>
                        <small class="text-muted">Valor Alvo</small>
                        <h5 class="mb-0">R$ {{ number_format($goal->target_value, 2, ',', '.') }}</h5>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="d-flex align-items-center">
                    <ion-icon name="wallet-outline" class="text-info fs-4 me-2"></ion-icon>
                    <div>
                        <small class="text-muted">Valor Atual</small>
                        <h5 class="mb-0">R$ {{ number_format($goal->current_value, 2, ',', '.') }}</h5>
                    </div>
                </div>
            </div>
        </div>

        <hr class="my-4">

        {{-- Progresso --}}
        <div class="mb-3">
            <small class="text-muted d-flex align-items-center mb-1">
                <ion-icon name="trending-up-outline" class="me-1 text-primary"></ion-icon>
                Progresso da Meta
            </small>

            <div class="progress" style="height: 25px;">
                <div
                    class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                    role="progressbar"
                    style="width: {{ min($goal->progress, 100) }}%;"
                    aria-valuenow="{{ $goal->progress }}"
                    aria-valuemin="0"
                    aria-valuemax="100">
                    {{ number_format($goal->progress, 2) }}%
                </div>
            </div>
        </div>

        {{-- Botão Voltar --}}
        <div class="d-flex justify-content-center mt-4">
            <a href="{{ route('goals.index') }}" class="btn btn-outline-primary rounded-pill px-4">
                <ion-icon name="arrow-back-outline" class="me-1"></ion-icon>
                Voltar
            </a>
        </div>
    </div>
</div>
@endsection
