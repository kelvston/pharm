@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Pharmacy Dashboard</h1>
        <div class="row">
            <!-- Total Medications -->
            <div class="col-md-4">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h4>Total Medications</h4>
                        <p>{{ $totalMedications }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Sales Today -->
            <div class="col-md-4">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h4>Total Sales Today</h4>
                        <p>{{ $totalSalesToday }}</p>
                    </div>
                </div>
            </div>

            <!-- Low Stock -->
            <div class="col-md-4">
                <div class="card bg-warning text-dark">
                    <div class="card-body">
                        <h4>Low Stock Medications</h4>
                        <ul>
                            @foreach($lowStockMedications as $med)
                                <li>{{ $med->name }} ({{ $med->stock }} left)</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Expiring Soon -->
        <div class="mt-4">
            <h3>Medications Expiring Soon</h3>
            <ul>
                @foreach($expiringSoon as $med)
                    <li>{{ $med->name }} (Expiry: {{ $med->expiry_date }})</li>
                @endforeach
            </ul>
        </div>

    </div>
@endsection
