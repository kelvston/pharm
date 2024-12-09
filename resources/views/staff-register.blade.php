@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Staff Registration</h2>
        <form action="{{ route('staff.register') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" name="name" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" required>
            </div>

            <div class="form-group">
                <label for="role">Role</label>
                <select name="role" class="form-control" required>
                    <option value="admin">Admin</option>
                    <option value="pharmacist">Pharmacist</option>
                    <option value="staff">Staff</option>
                </select>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" required>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" class="form-control" name="password_confirmation" required>
            </div>

            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>
@endsection
