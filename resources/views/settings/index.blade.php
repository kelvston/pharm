@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>System Settings</h2>

        <!-- Display success message -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Settings Form -->
        <form action="{{ route('settings.update') }}" method="POST">
            @csrf
            @method('POST')

            <div class="form-group">
                <label for="pharmacy_name">Pharmacy Name</label>
                <input type="text" name="pharmacy_name" id="pharmacy_name" class="form-control" value="{{ old('pharmacy_name', $settings->pharmacy_name) }}">
            </div>

            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" name="address" id="address" class="form-control" value="{{ old('address', $settings->address) }}">
            </div>

            <div class="form-group">
                <label for="contact_email">Contact Email</label>
                <input type="email" name="contact_email" id="contact_email" class="form-control" value="{{ old('contact_email', $settings->contact_email) }}">
            </div>

            <div class="form-group">
                <label for="contact_phone">Contact Phone</label>
                <input type="text" name="contact_phone" id="contact_phone" class="form-control" value="{{ old('contact_phone', $settings->contact_phone) }}">
            </div>

            <div class="form-group">
                <label for="tax_rate">Tax Rate (%)</label>
                <input type="number" name="tax_rate" id="tax_rate" class="form-control" value="{{ old('tax_rate', $settings->tax_rate) }}" min="0" max="100">
            </div>

            <div class="form-group">
                <label for="currency">Currency</label>
                <input type="text" name="currency" id="currency" class="form-control" value="{{ old('currency', $settings->currency) }}">
            </div>

            <button type="submit" class="btn btn-primary">Save Settings</button>
        </form>
    </div>
@endsection
