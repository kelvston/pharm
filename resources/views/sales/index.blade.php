@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Sales</h1>

        {{-- Display success or error messages --}}
        @if(session('success'))
            <div class="alert alert-success" id="successMessage">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger" id="errorMessage">
                {{ session('error') }}
            </div>
        @endif

        <a href="{{ route('sales.create') }}" class="btn btn-primary">Add Sale</a>

        {{ $sales->links() }}
    </div>

    <script>
        // Automatically hide alerts after 5 seconds (5000ms)
        setTimeout(function() {
            document.getElementById('successMessage')?.remove();
            document.getElementById('errorMessage')?.remove();
        }, 3000);
    </script>
@endsection
