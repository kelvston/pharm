@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Sales</h1>
        <a href="{{ route('sales.create') }}" class="btn btn-primary">Add Sale</a>
        <table class="table mt-3">
            <thead>
            <tr>
                <th>ID</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Total Amount</th>
                <th>Handled By</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($sales as $sale)
                <tr>
                    <td>{{ $sale->id }}</td>
                    <td>{{ $sale->medicine->product_name ?? 'N/A' }}</td>
                    <td>{{ $sale->quantity ?? 'N/A' }}</td>
                    <td>${{ number_format($sale->total_amount, 2) }}</td>
                    <td>{{ $sale->staff->name }}</td>
                    <td>
                        <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-info">View</a>
{{--                        <a href="{{ route('sales.edit', $sale->id) }}" class="btn btn-warning">Edit</a>--}}
{{--                        <form action="{{ route('sales.destroy', $sale->id) }}" method="POST" class="d-inline">--}}
{{--                            @csrf--}}
{{--                            @method('DELETE')--}}
{{--                            <button type="submit" class="btn btn-danger">Delete</button>--}}
{{--                        </form>--}}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $sales->links() }}
    </div>
@endsection
