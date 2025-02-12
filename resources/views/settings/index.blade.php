@extends('layouts.app')

@section('content')
    <div class="container custom-bg">
        <h2>System Settings</h2>

        <!-- Display success message -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Settings Form -->
        <form action="{{ route('settings.update') }}" method="POST">
            @csrf
            @method('POST')

            <div class="form-group position-relative mb-3">
                <label for="pharmacy_name">Pharmacy Name</label>
                <input type="text" name="pharmacy_name" id="pharmacy_name" class="form-control" value="{{ old('pharmacy_name', $settings?$settings->pharmacy_name:'') }}">
            </div>

            <div class="form-group position-relative mb-3">
                <label for="address">Address</label>
                <input type="text" name="address" id="address" class="form-control" value="{{ old('address', $settings?$settings->address:'') }}">
            </div>

            <div class="form-group position-relative mb-3">
                <label for="contact_email">Contact Email</label>
                <input type="email" name="contact_email" id="contact_email" class="form-control" value="{{ old('contact_email', $settings?$settings->contact_email:'') }}">
            </div>

            <div class="form-group position-relative mb-3">
                <label for="contact_phone">Contact Phone</label>
                <input type="text" name="contact_phone" id="contact_phone" class="form-control" value="{{ old('contact_phone', $settings?$settings->contact_phone:'') }}">
            </div>

            <div class="form-group position-relative mb-3">
                <label for="tax_rate">Tax Rate (%)</label>
                <input type="number" name="tax_rate" id="tax_rate" class="form-control" value="{{ old('tax_rate', $settings?$settings->tax_rate:'') }}" min="0" max="100">
            </div>

            <div class="form-group position-relative mb-3">
                <label for="currency">Currency</label>
                <input type="text" name="currency" id="currency" class="form-control" value="{{ old('currency', $settings?$settings->currency:'') }}">
            </div>

            <button type="submit" class="btn btn-primary">Save Settings</button>
        </form>
    </div>
@endsection
