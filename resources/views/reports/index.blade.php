@extends('layouts.app')

@section('title', 'Relatórios')

@section('content')

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<link rel="stylesheet" href="{{ asset('css/transactionsIndex.css') }}">

<div class="d-flex justify-content-start mb-3">
    <form action="" method="get">
        <div class="row align-items-center g-2">
            <div class="col-12 col-md-3">
                <label for="start_date" class="form-label mb-0">De</label>
                <input type="date" class="form-control" name="start_date" id="start_date">
            </div>

            <div class="col-12 col-md-3">
                <label for="end_date" class="form-label mb-0">Até</label>
                <input type="date" class="form-control" name="end_date" id="end_date">
            </div>

            <div class="col-12 col-md-3">
                <label for="category" class="form-label mb-0">Categoria</label>
                <select class="form-select" name="category" id="category">
                    <option value="" selected>Selecione...</option>
                    @foreach($filterCategories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-12 col-md-2 d-flex align-items-end">
                <button class="btn btn-primary w-100" id="filter-button">Filtrar</button>
            </div>
        </div>
    </form>
</div>

<!-- TABS -->
<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item">
        <button class="nav-link active" id="transaction-tab" data-bs-toggle="tab" data-bs-target="#transaction-tab-pane" type="button">
            Transações
        </button>
    </li>
    <li class="nav-item">
        <button class="nav-link" id="category-tab" data-bs-toggle="tab" data-bs-target="#category-tab-pane" type="button">
            Categorias
        </button>
    </li>
    <li class="nav-item">
        <button class="nav-link" id="goal-tab" data-bs-toggle="tab" data-bs-target="#goal-tab-pane" type="button">
            Metas
        </button>
    </li>
</ul>

<!-- TAB CONTENT -->
<div class="tab-content mt-3" id="myTabContent">

    <!-- ==================== TAB TRANSAÇÕES ==================== -->
    <div class="tab-pane fade show active" id="transaction-tab-pane" role="tabpanel">

        <h3 class="mb-3">KPIs de Transações</h3>

        <div class="row g-3">

            <div class="col-12 col-md-4">
                <div class="card bg-primary text-white shadow-sm">
                    <div class="card-body d-flex justify-content-between">
                        <div>
                            <h6>Total Entradas</h6>
                            <h3>{{ 'R$ ' . number_format($transactions->total_income, 2, ',', '.') }}</h3>
                        </div>
                        <ion-icon name="arrow-up-circle" size="large"></ion-icon>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="card bg-danger text-white shadow-sm">
                    <div class="card-body d-flex justify-content-between">
                        <div>
                            <h6>Total Saídas</h6>
                            <h3>{{ 'R$ ' . number_format($transactions->total_expense, 2, ',', '.') }}</h3>
                        </div>
                        <ion-icon name="arrow-down-circle" size="large"></ion-icon>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="card bg-success text-white shadow-sm">
                    <div class="card-body d-flex justify-content-between">
                        <div>
                            <h6>Saldo Atual</h6>
                            <h3>{{ 'R$ ' . number_format($transactions->current_balance, 2, ',', '.') }}</h3>
                        </div>
                        <ion-icon name="wallet" size="large"></ion-icon>
                    </div>
                </div>
            </div>

        </div>

        <h4 class="mt-4">Gráfico de Entradas vs Saídas</h4>

        <canvas id="transactionChart" height="120"></canvas>

        <h4 class="mt-4">Lista de Transações</h4>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Categoria</th>
                        <th>Valor</th>
                        <th>Tipo</th>
                        <th>Data</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactionsList as $transaction)
                    <tr>
                        <td>
                            <span class="badge rounded-pill" style="background-color: {{ $transaction->category->color }}; opacity: 0.3; color: #222;">
                                &nbsp;
                            </span>
                            {{ $transaction->category->name }}
                        </td>
                        <td>{{ 'R$ ' . number_format($transaction->value, 2, ',', '.') }}</td>
                        <td>{{ ($transaction->type) ? 'Receita' : 'Despesa' }}</td>
                        <td>{{ \Carbon\Carbon::parse($transaction->date)->format('d/m/Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $transactionsList->links() }}

    </div>

    <!-- ==================== TAB CATEGORIAS ==================== -->
    <div class="tab-pane fade" id="category-tab-pane" role="tabpanel">

        <h3 class="mb-3">Participação por Categoria</h3>

        <canvas id="categoryChart" height="120"></canvas>

        <h4 class="mt-4">Resumo das Categorias</h4>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Categoria</th>
                        <th>Total (R$)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories->list as $category)
                    <tr>
                        <td>
                            {{ $category->name }}
                        </td>
                        <td>
                            {{ 'R$ ' . number_format($category->total, 2, ',', '.') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>

    <!-- ==================== TAB METAS ==================== -->
    <div class="tab-pane fade" id="goal-tab-pane" role="tabpanel">

        <h3 class="mb-3">Progresso das Metas</h3>

        <div class="row g-3">

            @foreach($goals->list as $goal)

                <div class="col-12 col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5>{{ $goal->category->name }}</h5>
                            <p>Mês {{ $goal->month .'/'.$goal->year}}</p>

                            <div class="progress mb-2">
                                <div class="progress-bar" role="progressbar" style="width: {{ $goal->progress }}%; background-color: {{ $goal->category->color }}">
                                    {{ number_format($goal->progress, 2, ',', '.') }}%
                                </div>
                            </div>

                            <small>Atual: R$ {{ number_format($goal->current_value, 2, ',', '.') }}</small><br>
                            <small>Meta: R$ {{ number_format($goal->target_value, 2, ',', '.') }}</small>
                        </div>
                    </div>
                </div>

            @endforeach

        <h4 class="mt-4">Gráfico de Metas</h4>

        <canvas id="goalChart" height="120"></canvas>

    </div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // ------------------ TRANSAÇÕES
        new Chart(document.getElementById('transactionChart'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($transactions->chart_data['labels']) !!},
                datasets: [{
                    label: 'Valor (R$)',
                    data: {!! json_encode($transactions->chart_data['data']) !!},
                    borderWidth: 1
                }]
            }
        });

        // ------------------ CATEGORIAS
        new Chart(document.getElementById('categoryChart'), {
            type: 'pie',
            data: {
                labels: {!! json_encode($categories->chartData['labels']) !!},
                datasets: [{
                    data: {!! json_encode($categories->chartData['data']) !!}
                }]
            }
        });

        // ------------------ METAS
        new Chart(document.getElementById('goalChart'), {
            type: 'line',
            data: {
                labels: {!! json_encode($goals->chartData['labels']) !!},
                datasets: [{
                    label: 'Progresso (%)',
                    data: {!! json_encode($goals->chartData['data']) !!},
                    borderWidth: 2
                }]
            }
        });

    });
</script>

@endsection
