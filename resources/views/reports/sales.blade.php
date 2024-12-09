@extends('layouts.app')

@section('content')
    <style>
        .navigate {
            list-style: none; /* Removes bullet points */
            padding: 0;
            margin: 0;
            display: flex; /* Aligns list items in a row */
            justify-content: flex-start; /* Aligns items to the left */
            gap: 20px; /* Adds space between items */
        }

        .navigate .list {
            margin: 0;
        }

        .navigate a {
            text-decoration: none; /* Removes underline from links */
            color: #007bff; /* Link color */
            font-weight: 500; /* Slightly bold text for emphasis */
            padding: 8px 16px; /* Padding for clickable area */
            border-radius: 5px; /* Rounded corners for buttons */
            transition: background-color 0.3s, color 0.3s; /* Smooth hover effects */
        }

        .navigate a:hover {
            background-color: #007bff; /* Blue background on hover */
            color: #fff; /* White text on hover */
        }


    </style>
        <ul class="navigate">
            <li>
                <a href="/inventory-report">Inventory</a>
            </li>
            <li>
                <a href="/revenue-report">Revenue</a>
            </li>
        </ul>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <h2 class="mb-4 text-primary">Sales Report</h2>

                <!-- Report Filters -->
                <form action="{{ route('sales.report') }}" method="GET" class="mb-4">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input
                                type="date"
                                class="form-control"
                                name="start_date"
                                value="{{ request('start_date', now()->subMonth()->toDateString()) }}">
                        </div>
                        <div class="col-md-4">
                            <label for="end_date" class="form-label">End Date</label>
                            <input
                                type="date"
                                class="form-control"
                                name="end_date"
                                value="{{ request('end_date', now()->toDateString()) }}">
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary w-100">
                                Generate Report
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Total Sales -->
                <div class="card bg-light mb-4">
                    <div class="card-body">
                        <h5 class="card-title text-success">Total Sales</h5>
                        <p class="card-text fs-4">
                            {{ number_format($totalSales, 2) }}
                        </p>
                    </div>
                </div>
{{--                @dd($expensesByCategory)--}}
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title text-info">Expense Summary</h5>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>Total Expenses</th>
                                <th>Expenses by Category</th>
                                <th>Net Profit</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>{{ number_format($totalExpenses, 2) }}</td>
                                <td>
                                    <ul>
                                        @foreach ($expensesByCategory as $expense)
                                            <li>{{ $expense->category }}: {{ number_format($expense->total_amount, 2) }}</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>{{ number_format($netProfit, 2) }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Sales by Medication -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title text-info">Sales by Medication</h5>
                        @if ($salesByMedication->isEmpty())
                            <p class="text-muted">No sales data available for the selected date range.</p>
                        @else
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Medication</th>
                                    <th>Quantity Sold</th>
                                    <th>Total Sell</th>
                                    <th>Total Cost</th>
                                    <th>Profit</th>
                                    <th>% Profit</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($salesByMedication as $sale)
                                    <tr>
                                        <td>{{ $sale->product_name }}</td>
                                        <td>{{ $sale->total_quantity }}</td>
                                        <td>{{ number_format($sale->total_sales, 2) }}</td>
                                        <td>{{ number_format($sale->total_cost, 2) }}</td>
                                        <td>{{ number_format($sale->profit, 2) }}</td>
                                        <td>{{ $sale->percentage_profit }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>

                <!-- Sales Trends (Daily) -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-warning">Sales Trends (Daily)</h5>
                        @if ($salesTrends->isEmpty())
                            <p class="text-muted">No sales trend data available for the selected date range.</p>
                        @else
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Daily Sales</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($salesTrends as $trend)
                                    <tr>
                                        <td>{{ $trend->sale_date }}</td>
                                        <td>{{ number_format($trend->daily_sales, 2) }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
