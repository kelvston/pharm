@extends('layouts.app')
@section('content')
    <div class="container custom-bg">
<h1>Visitors Data</h1>
@if(isset($visitorsData['status']) && $visitorsData['status'] == 'success')
    <h2>Visitor Count: {{ $visitorsData['data']['data']['count'] }}</h2>
    <p>Male: {{ $visitorsData['data']['data']['gender']['male'] }}</p>
    <p>Female: {{ $visitorsData['data']['data']['gender']['female'] }}</p>
@else
    <p>Error fetching data: {{ $visitorsData['message'] ?? 'Unknown error' }}</p>
@endif
    </div>
@endsection
