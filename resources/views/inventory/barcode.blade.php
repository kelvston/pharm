@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>{{ $medicine->medicinelist[0]->product_name }}</h2>

        <!-- Display the barcode image -->
        <div>
            <!-- Use the base64 encoded string for the barcode -->
            <img src="{{ asset('storage/' . $medicine->barcode_image) }}" alt="Barcode for {{ $medicine->medicinelist[0]->product_name }}">
{{--            <img src="data:image/png;base64,{{ $barcodeImage }}" alt="Barcode for {{ $medicine->medicinelist[0]->product_name }}">--}}
        </div>
    </div>
@endsection
