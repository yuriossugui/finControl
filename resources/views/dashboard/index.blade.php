@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<link rel="stylesheet" href="{{ asset('css/transactionsIndex.css') }}">

<h2 class="mt-4 mb-3">Resumo Financeiro</h2>
<div class="row g-3">
    <div class="col-12 col-md-4">
        <div class="card bg-success text-white shadow-sm">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6>Saldo Atual</h6>
                    <h3>R$ {{ number_format($currentBalance, 2, ',', '.') }}</h3>
                    <small class="text-white-50">{{ number_format($balanceVariation, 2, ',', '.') }}% em relação ao mês anterior</small>
                </div>
                <ion-icon name="wallet" size="large"></ion-icon>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="card bg-primary text-white shadow-sm">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6>Total Receitas (Nov)</h6>
                    <h3>R$ {{ number_format($totalIncome, 2, ',', '.') }}</h3>
                    <small class="text-white-50">{{ number_format($incomeVariation, 2, ',', '.') }}% vs mês anterior</small>
                </div>
                <ion-icon name="arrow-up-circle" size="large"></ion-icon>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="card bg-danger text-white shadow-sm">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h6>Total Despesas (Nov)</h6>
                    <h3>R$ {{ number_format($totalExpense, 2, ',', '.') }}</h3>
                    <small class="text-white-50">{{ number_format($expenseVariation, 2, ',', '.') }}% vs mês anterior</small>
                </div>
                <ion-icon name="arrow-down-circle" size="large"></ion-icon>
            </div>
        </div>
    </div>
</div>

<h4 class="mt-5">Desempenho Mensal</h4>
<div class="row">
    <div class="col-12 col-lg-8">
        <canvas id="monthlyChart" height="120"></canvas>
    </div>
    <div class="col-12 col-lg-4">
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <h6 class="mb-2">Comparativo Mês Anterior</h6>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Receitas</span>
                        <span class="badge bg-primary">R$ {{ number_format($lastMonthIncome, 2, ',', '.') }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Despesas</span>
                        <span class="badge bg-danger">R$ {{ number_format($lastMonthExpense, 2, ',', '.') }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Saldo</span>
                        <span class="badge bg-success">R$ {{ number_format($lastMonthBalance, 2, ',', '.') }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<h4 class="mt-5">Participação por Categoria</h4>
<div class="row">
    <div class="col-12 col-lg-6">
        <canvas id="categoryChart" height="120"></canvas>
    </div>
    <div class="col-12 col-lg-6">
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Categoria</th>
                    <th>Total (R$)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categoriesList as $categoryName => $transactions)
                    <tr>
                        <td>{{ $categoryName }}</td>
                        <td>
                            R$ {{ number_format($transactions->sum('value'), 2, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gráfico de desempenho mensal
        new Chart(document.getElementById('monthlyChart'), {
            type: 'line',
            data: {
                labels: @json($monthlyChartData->labels),
                datasets: [
                    {
                        label: 'Receitas',
                        data: @json($monthlyChartData->income),
                        borderColor: '#0d6efd',
                        backgroundColor: 'rgba(13,110,253,0.1)',
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Despesas',
                        data: @json($monthlyChartData->expense),
                        borderColor: '#dc3545',
                        backgroundColor: 'rgba(220,53,69,0.1)',
                        fill: true,
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' }
                }
            }
        });

        // Gráfico de categorias
        new Chart(document.getElementById('categoryChart'), {
            type: 'pie',
            data: {
                labels: @json($categoryChartData->labels),
                datasets: [{
                    data: @json($categoryChartData->totals),
                    backgroundColor: @json($categoryChartData->colors)
                }]
            },
            options: {
                responsive: true
            }
        });
    });
</script>

@endsection