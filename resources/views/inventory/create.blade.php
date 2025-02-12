@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Create Medicine</h2>
        <form action="/inventory" method="POST" class="p-4 shadow-sm rounded border custom-bg">

        @csrf

            <!-- Search Medicine Field -->
            <div class="form-group position-relative mb-3">
                <label for="medicine_name" class="form-label">Medicine Name</label>
                <input type="text" class="form-control" id="medicine-search" placeholder="Search for a medicine" required>
                <ul id="medicine-suggestions" class="list-group mt-1"></ul>
                <input type="hidden" id="medicine_id" name="medicine_id">
            </div>

            <!-- Quantity Field -->
            <div class="form-group mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" class="form-control" id="quantity" name="quantity" required>
            </div>

            <!-- Unit Price Field -->
            <div class="form-group mb-3">
                <label for="unit_price" class="form-label">Unit Price</label>
                <input type="number" class="form-control" id="unit_price" name="unit_price" step="0.01" required>
            </div>

            <!-- Sell Price Field -->
            <div class="form-group mb-3">
                <label for="sell_price" class="form-label">Sell Price</label>
                <input type="number" class="form-control" id="sell_price" name="sell_price" step="0.01" required>
            </div>

            <!-- Unit Cost Field -->
            <div class="form-group mb-3">
                <label for="unit_cost" class="form-label">Unit Cost</label>
                <input type="text" class="form-control" id="unit_cost" name="unit_cost" readonly>
            </div>

            <!-- Expiry Date Field -->
            <div class="form-group mb-3">
                <label for="expiry_date" class="form-label">Expiry Date</label>
                <input type="date" class="form-control" id="expiry_date" name="expiry_date" required>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary w-100 mt-3">Submit</button>
        </form>

    </div>
    <div class="container my-5">
        <h2 class="text-center mb-4">Upload Bulk Medicines</h2>

        <!-- Instruction Section -->
        <div class="alert alert-info" role="alert">
            <h5>Instructions:</h5>
            <ul>
                <li>Download the <a href="/templates/medicine-upload-template.xlsx" class="text-decoration-underline">Excel Template</a>
                    .</li>
                <li>Fill in the details for each medicine in the provided format.</li>
                <li>Save the file as .xlsx or .csv and upload it below.</li>
                <li>Columns include:
                    <strong>Product Name, Generic Name, Category, Quantity, Unit Price, Sell Price, Expiry Date (MM/DD/YYYY)</strong>.
                </li>
            </ul>
        </div>

        <!-- Upload Form -->
        <form action="{{ route('medicines.upload') }}" method="POST" enctype="multipart/form-data" class="border p-4 shadow rounded">
            @csrf

            <div class="mb-3">
                <label for="file" class="form-label">Select Excel File:</label>
                <input type="file" name="file" id="file" class="form-control @error('file') is-invalid @enderror" accept=".xlsx, .csv" required>
                @error('file')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary w-100">Upload</button>
        </form>

        <!-- Success or Error Messages -->
        @if(session('success'))
            <div class="alert alert-success mt-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger mt-4">
                {{ session('error') }}
            </div>
        @endif
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>


    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            // Handle the keyup event for searching medicines
            $('#medicine-search').on('keyup', function () {
                var query = $(this).val();
                if (query.length > 2) {  // Only search after 3 characters are typed
                    $.ajax({
                        url: "{{ route('medicines.search') }}",
                        type: "GET",
                        data: { query: query },
                        success: function (data) {
                            // Empty the suggestion list and show it
                            $('#medicine-suggestions').empty().show();

                            // If there are suggestions, append them to the list
                            if (data.length > 0) {
                                data.forEach(function (medicine) {
                                    $('#medicine-suggestions').append(
                                        '<li class="list-group-item suggestion-item" data-id="' + medicine.id + '">' +
                                        medicine.product_name +
                                        (medicine.generic_name ? ' (' + medicine.generic_name + ')' : '') +
                                        (medicine.category ? ' [' + medicine.category + ']' : '') +
                                        '</li>'
                                    );



                                });
                            } else {
                                $('#medicine-suggestions').append('<li class="list-group-item">No medicines found</li>');
                            }
                        },
                        error: function () {
                            $('#medicine-suggestions').empty().append('<li class="list-group-item">Error fetching data</li>').show();
                        }
                    });
                } else {
                    $('#medicine-suggestions').hide();  // Hide suggestions if query length is less than 3
                }
            });

            // When a suggestion item is clicked
            $(document).on('click', '.suggestion-item', function () {
                var selectedMedicine = $(this).text();  // Get the selected medicine name
                var medicineId = $(this).data('id');   // Get the medicine ID
                $('#medicine-search').val(selectedMedicine);  // Fill the search input
                $('#medicine_id').val(medicineId);  // Store the selected medicine ID in hidden input
                $('#medicine-suggestions').hide();  // Hide the suggestions
            });

            // Calculate unit cost based on quantity and unit price
            document.getElementById('quantity').addEventListener('input', updateUnitCost);
            document.getElementById('unit_price').addEventListener('input', updateUnitCost);

            function updateUnitCost() {
                var quantity = parseFloat(document.getElementById('quantity').value) || 0;
                var unitPrice = parseFloat(document.getElementById('unit_price').value) || 0;
                var unitCost = quantity * unitPrice;
                document.getElementById('unit_cost').value = unitCost.toFixed(2);
            }

            // Close the suggestions when clicking outside the suggestions box
            $(document).mouseup(function (e) {
                var container = $("#medicine-suggestions");
                var searchBox = $("#medicine-search");

                if (!container.is(e.target) && !searchBox.is(e.target) && container.has(e.target).length === 0) {
                    container.hide();
                }
            });
        });
    </script>
@endsection
