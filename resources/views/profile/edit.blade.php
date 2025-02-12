@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Profile</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group mb-3">
                <label for="name">Name</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="form-control">
            </div>

            <div class="form-group mb-3">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="form-control">
            </div>

            <div class="form-group mb-3">
                <label for="profile_picture">Profile Picture</label><br>
                @if ($user->profile_picture)
                    <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture" class="img-thumbnail mb-3" style="width: 150px; height: 150px;">
                @endif
                <input type="file" id="profile_picture" name="profile_picture" class="form-control">
            </div>

            <div class="form-group mb-3">
                <label for="password">New Password (optional)</label>
                <input type="password" id="password" name="password" class="form-control">
            </div>

            <div class="form-group mb-3">
                <label for="password_confirmation">Confirm New Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>
@endsection
