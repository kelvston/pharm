@extends('layouts.app')

@section('title', 'Inventory')

@section('content')
    <div class="custom-bg">
    <h1>Add Medication</h1>
    <a href="/inventory/create" class="btn btn-primary">Add Medicine</a>
    <a href="/inventory/show" class="btn btn-primary">Medicines List</a>
    <a href="/stock-takes" class="btn btn-primary">stock Management</a>
    <table class="table table-bordered mt-3">
        <thead>
        <tr>
            <th>Name</th>
            <th>Category</th>
            <th>Quantity</th>
            <th>Unit Price</th>
            <th>Sell Price</th>
            <th>Expiry Date</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>

        @foreach ($medicines as $medicine)
            <tr>
                <td>{{ $medicine->medicinelist[0]->product_name}}</td>
                <td>{{ $medicine->medicinelist[0]->category }}</td>
                <td>{{ $medicine->quantity }}</td>
                <td>${{ $medicine->unit_price }}</td>
                <td>${{ $medicine->sell_price }}</td>
                <td>{{ $medicine->expiry_date }}</td>
                <td>
                    <a href="/inventory/{{ $medicine->id }}/edit" class="btn btn-warning btn-sm">Edit</a>
                    <form method="POST" action="/inventory/{{ $medicine->id }}" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    </div>
@endsection
