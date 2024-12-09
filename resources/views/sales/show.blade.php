@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Sale Details</h1>
        <table class="table">
            <tr>
                <th>ID</th>
                <td>{{ $sale->id }}</td>
            </tr>
            <tr>
                <th>Product Name</th>
                <td>{{ $sale->medicine->product_name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Total Amount</th>
                <td>${{ number_format($sale->total_amount, 2) }}</td>
            </tr>
            <tr>
                <th>Handled By</th>
                <td>{{ $sale->staff->name }}</td>
            </tr>
            <tr>
                <th>Created At</th>
                <td>{{ $sale->created_at->format('Y-m-d H:i') }}</td>
            </tr>
            <tr>
                <th>Updated At</th>
                <td>{{ $sale->updated_at->format('Y-m-d H:i') }}</td>
            </tr>
        </table>
        <a href="{{ route('sales.index') }}" class="btn btn-secondary">Back to Sales</a>
    </div>
@endsection
