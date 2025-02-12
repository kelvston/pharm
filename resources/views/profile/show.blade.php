@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>My Profile</h2>
        @if ($user->profile_picture)
            <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Profile Picture" class="img-thumbnail mb-3" style="width: 150px; height: 150px;">
        @endif
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">{{ $user->name }}</h4>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Role:</strong> {{ $user->role }}</p>
                <p><strong>Joined On:</strong> {{ $user->created_at->format('M d, Y') }}</p>
            </div>
        </div>

        <a href="{{ route('profile.edit') }}" class="btn btn-primary mt-3">Edit Profile</a>
    </div>
@endsection

