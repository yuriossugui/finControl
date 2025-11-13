@extends('layouts.app')

@section('title', 'Editar Meta')

@section('content')
<div class="container my-4">

    {{-- Título --}}
    <div class="d-flex justify-content-center mb-3">
        <h2>
            <ion-icon name="create" class="me-2"></ion-icon>
            Editar Meta
        </h2>
    </div>

    {{-- Exibição de erros --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Card principal --}}
    <div class="card shadow-sm p-4 border-0 rounded-4">
        <form action="{{ route('goals.update', $goal->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Categoria --}}
            <div class="mb-3">
                <label for="category_id" class="form-label fw-semibold">Categoria</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><ion-icon name="list"></ion-icon></span>
                    <select name="category_id" id="category_id" class="form-select" required>
                        <option value="">Selecione uma categoria</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ $goal->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Valores --}}
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="target_value" class="form-label fw-semibold">Valor Alvo (R$)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><ion-icon name="cash"></ion-icon></span>
                        <input 
                            type="text" 
                            name="target_value" 
                            id="target_value" 
                            class="form-control" 
                            value="{{ $goal->target_value }}" 
                            required
                        >
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="current_value" class="form-label fw-semibold">Valor Atual (R$)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><ion-icon name="wallet"></ion-icon></span>
                        <input 
                            type="text" 
                            name="current_value" 
                            id="current_value" 
                            class="form-control" 
                            value="{{ $goal->current_value }}" 
                            required
                        >
                    </div>
                </div>
            </div>

            {{-- Mês e Ano --}}
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="month" class="form-label fw-semibold">Mês</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><ion-icon name="calendar"></ion-icon></span>
                        <select name="month" id="month" class="form-select" required>
                            <option value="">Selecione o mês</option>
                            @foreach ([
                                '01' => 'Janeiro', '02' => 'Fevereiro', '03' => 'Março',
                                '04' => 'Abril', '05' => 'Maio', '06' => 'Junho',
                                '07' => 'Julho', '08' => 'Agosto', '09' => 'Setembro',
                                '10' => 'Outubro', '11' => 'Novembro', '12' => 'Dezembro'
                            ] as $num => $nome)
                                <option value="{{ $num }}" {{ $goal->month == $num ? 'selected' : '' }}>
                                    {{ $nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="year" class="form-label fw-semibold">Ano</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><ion-icon name="time"></ion-icon></span>
                        <input 
                            type="number" 
                            name="year" 
                            id="year" 
                            class="form-control" 
                            value="{{ $goal->year }}" 
                            min="2000" 
                            max="2100" 
                            required
                        >
                    </div>
                </div>
            </div>

            {{-- Progresso atual --}}
            <div class="mb-4">
                <small class="text-muted d-flex align-items-center mb-1">
                    <ion-icon name="trending-up" class="me-1 text-primary"></ion-icon>
                    Progresso Atual
                </small>
                <div class="progress" style="height: 25px;">
                    <div
                        class="progress-bar progress-bar-striped bg-success"
                        role="progressbar"
                        style="width: {{ min($goal->progress, 100) }}%;"
                        aria-valuenow="{{ $goal->progress }}"
                        aria-valuemin="0"
                        aria-valuemax="100">
                        {{ number_format($goal->progress, 2) }}%
                    </div>
                </div>
            </div>

            {{-- Botões --}}
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('goals.index') }}" class="btn btn-secondary rounded-pill px-4">
                    <ion-icon name="arrow-back" class="me-1"></ion-icon>
                    Cancelar
                </a>
                <button type="submit" class="btn btn-primary rounded-pill px-4">
                    <ion-icon name="save" class="me-1"></ion-icon>
                    Salvar Alterações
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
