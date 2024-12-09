@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Revenue Report</h2>
        <p>Total Revenue: {{ number_format($totalRevenue, 2) }}</p>
        <p>Cost of Goods Sold (COGS): {{ number_format($cogs, 2) }}</p>
        <p>Expenses:  {{ $totalExpenses }}</p>
        <p>Net Profit: {{ $netProfit }}</p>
        <p>Profit Margin: {{ number_format($profitMargin, 2) }}%</p>
    </div>

@endsection
