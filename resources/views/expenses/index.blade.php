@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Expenses</h1>
        <a href="{{ route('expenses.create') }}" class="btn btn-primary mb-3">Add Expense</a>
        @if ($expenses->count())
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($expenses as $expense)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $expense->title }}</td>
                        <td>{{ $expense->amount }}</td>
                        <td>{{ $expense->expense_date }}</td>
                        <td>
                            <a href="{{ route('expenses.edit', $expense) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('expenses.destroy', $expense) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $expenses->links() }}
        @else
            <p>No expenses recorded yet.</p>
        @endif
    </div>
@endsection
