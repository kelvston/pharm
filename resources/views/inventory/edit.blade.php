@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Edit Medicine</h2>

        <form method="POST" action="/inventory/{{ $medicine->id }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')  <!-- Indicates the form is for an UPDATE request -->

            <!-- Medicine Name -->
            <div class="form-group">
                <label for="name">Medicine Name:</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $medicine->name) }}" required>
            </div>

            <!-- Category Dropdown with Select2 -->
            <div class="form-group">
                <label for="category_id">Category:</label>
                <select class="form-control select2" id="category_id" name="category_id" required>
                    <option value="">Select Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $medicine->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Quantity -->
            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="number" class="form-control" id="quantity" name="quantity" value="{{ old('quantity', $medicine->quantity) }}" required>
            </div>

            <!-- Unit Price -->
            <div class="form-group">
                <label for="unit_price">Unit Price:</label>
                <input type="number" class="form-control" id="unit_price" name="unit_price" value="{{ old('unit_price', $medicine->unit_price) }}" required>
            </div>

            <!-- Unit Cost (Calculated dynamically) -->
            <div class="form-group">
                <label for="unit_cost">Unit Cost:</label>
                <input type="text" class="form-control" id="unit_cost" name="unit_cost" value="{{ old('unit_cost', $medicine->unit_cost) }}" readonly>
            </div>

            <!-- Expiry Date -->
            <div class="form-group">
                <label for="expiry_date">Expiry Date:</label>
                <input type="date" class="form-control" id="expiry_date" name="expiry_date" value="{{ old('expiry_date', $medicine->expiry_date) }}" required>
            </div>

            <!-- Submit Button -->
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Update Medicine</button>
            </div>
        </form>
    </div>


   @section('scripts')
        <script>
            $(document).ready(function() {
                // Initialize Select2 for category dropdown
                $('#category_id').select2({
                    placeholder: "Select a category",  // Placeholder text
                    allowClear: true                  // Allows clearing the selection
                });

                // Function to update unit cost dynamically based on quantity and unit price
                function updateUnitCost() {
                    var quantity = parseFloat($('#quantity').val()) || 0;  // Get quantity value
                    var unitPrice = parseFloat($('#unit_price').val()) || 0;  // Get unit price value
                    var unitCost = quantity * unitPrice;  // Calculate unit cost

                    $('#unit_cost').val(unitCost.toFixed(2));  // Update unit_cost field
                }

                // Listen for input change in quantity and unit_price fields
                $('#quantity').on('input', updateUnitCost);  // Recalculate unit cost on quantity change
                $('#unit_price').on('input', updateUnitCost);  // Recalculate unit cost on unit price change

                // Initially calculate unit cost on page load in case there are pre-filled values
                updateUnitCost();
            });
        </script>
    @endsection

@endsection
