@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Edit Staff Member</h2>
        <form action="{{ route('staff.update', $staff->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="name" value="{{ $staff->name }}" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" value="{{ $staff->email }}" required>
            </div>

            <div class="form-group">
                <label for="role">Role</label>
                <select name="role" class="form-control" required>
                    <option value="admin" {{ $staff->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="pharmacist" {{ $staff->role == 'pharmacist' ? 'selected' : '' }}>Pharmacist</option>
                    <option value="staff" {{ $staff->role == 'staff' ? 'selected' : '' }}>Staff</option>
                </select>
            </div>

            <div class="form-group">
                <label for="password">Password (Leave blank to keep current)</label>
                <input type="password" class="form-control" name="password">
            </div>

            <button type="submit" class="btn btn-primary">Update Staff</button>
        </form>
    </div>
@endsection
