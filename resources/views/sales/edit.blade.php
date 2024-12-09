@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Sale</h1>
        <form action="{{ route('sales.update', $sale->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="customer_name" class="form-label">Customer Name</label>
                <input type="text" name="customer_name" id="customer_name" class="form-control" value="{{ old('customer_name', $sale->customer_name) }}">
            </div>
            <div class="mb-3">
                <label for="total_amount" class="form-label">Total Amount</label>
                <input type="number" name="total_amount" id="total_amount" class="form-control" step="0.01" value="{{ old('total_amount', $sale->total_amount) }}" required>
            </div>
            <button type="submit" class="btn btn-warning">Update</button>
            <a href="{{ route('sales.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
