@extends('layouts.app')

@section('content')
    <div class="container custom-bg">
        <h2>Staff Members</h2>
        <a href="{{ route('staff.create') }}" class="btn btn-success mb-3">Add New Staff</a>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table">
            <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($staff as $staffMember)
                <tr>
                    <td>{{ $staffMember->name }}</td>
                    <td>{{ $staffMember->email }}</td>
                    <td>{{ ucfirst($staffMember->role) }}</td>
                    <td>
                        <a href="{{ route('staff.edit', $staffMember->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('staff.destroy', $staffMember->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
