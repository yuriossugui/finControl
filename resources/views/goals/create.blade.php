@extends('layouts.app')

@section('title', 'Adicionar Meta')

@section('content')

<div class="container my-4">
    <div class="d-flex justify-content-center mb-3">
        <h2><ion-icon name="flag" class="me-2"></ion-icon>Adicionar Meta</h2>
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

    <div class="card shadow-sm p-3 rounded-4 border-0">
        <form action="{{ route('goals.store') }}" method="POST">
            @csrf

            {{-- Categoria --}}
            <div class="mb-3">
                <label for="category_id" class="form-label fw-semibold">Categoria</label>
                <div class="input-group">
                    <span class="input-group-text bg-light"><ion-icon name="list"></ion-icon></span>
                    <select name="category_id" id="category_id" class="form-select" required>
                        <option value="" selected>Selecione uma categoria</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Valor alvo e valor atual --}}
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="target_value" class="form-label fw-semibold">Valor Alvo (R$)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><ion-icon name="cash"></ion-icon></span>
                        <input type="text" class="form-control" id="target_value" name="target_value" placeholder="Ex: 5000.00" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="current_value" class="form-label fw-semibold">Valor Atual (R$)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><ion-icon name="wallet"></ion-icon></span>
                        <input type="text" class="form-control" id="current_value" name="current_value" placeholder="Ex: 1200.00" required>
                    </div>
                </div>
            </div>

            {{-- Mês e ano --}}
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label for="month" class="form-label fw-semibold">Mês</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><ion-icon name="calendar"></ion-icon></span>
                        <select name="month" id="month" class="form-select" required>
                            <option value="" selected>Selecione o mês</option>
                            @foreach ([
                                '01' => 'Janeiro', '02' => 'Fevereiro', '03' => 'Março',
                                '04' => 'Abril', '05' => 'Maio', '06' => 'Junho',
                                '07' => 'Julho', '08' => 'Agosto', '09' => 'Setembro',
                                '10' => 'Outubro', '11' => 'Novembro', '12' => 'Dezembro'
                            ] as $num => $nome)
                                <option value="{{ $num }}">{{ $nome }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="year" class="form-label fw-semibold">Ano</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><ion-icon name="time"></ion-icon></span>
                        <input type="number" name="year" id="year" class="form-control" placeholder="{{ date('Y') }}" min="2025" max="2100" required>
                    </div>
                </div>
            </div>

            {{-- Botão de envio --}}
            <div class="d-flex justify-content-center mt-4">
                <button type="submit" class="btn btn-primary px-4 py-2 rounded-pill">
                    <ion-icon name="checkmark-circle" class="me-1"></ion-icon>
                    Registrar Meta
                </button>
            </div>

        </form>
    </div>
</div>

<script src="{{ asset('js/createGoal.js') }}"></script>

@endsection
