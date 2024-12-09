@extends('layouts.app')
@section('content')
    <div class="container mt-4">
        <h2 class="mb-4 text-primary">Inventory Report</h2>

        <!-- Current Stock Levels Section -->
        <div class="card mb-4">
            <div class="card-body">
                <h4 class="card-title text-success">Current Stock Levels</h4>
                @if ($stockLevels->isEmpty())
                    <p class="text-muted">No stock data available at the moment.</p>
                @else
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Medication</th>
                            <th>Quantity in Stock</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($stockLevels as $item)
                            <tr>
                                <td>{{ $item->product_name }}</td>
                                <td>{{ $item->quantity }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

        <!-- Expired Medications Section -->
        <div class="card mb-4">
            <div class="card-body">
                <h4 class="card-title text-danger">Expired Medications</h4>
                @if ($expiredMedications->isEmpty())
                    <p class="text-muted">No expired medications found.</p>
                @else
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Medication</th>
                            <th>Expiry Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($expiredMedications as $item)
                            <tr>
                                <td>{{ $item->product_name }}</td>
                                <td>{{ $item->expiry_date }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

        <!-- Low Stock Alerts Section -->
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-warning">Low Stock Alerts</h4>
                @if ($lowStock->isEmpty())
                    <p class="text-muted">No low stock alerts at this time.</p>
                @else
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Medication</th>
                            <th>Quantity in Stock</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($lowStock as $item)
                            <tr>
                                <td>{{ $item->product_name }}</td>
                                <td>{{ $item->quantity }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
@endsection
