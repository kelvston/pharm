@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Create Medicine</h2>
        <form action="/inventory" method="POST">
            @csrf

            <!-- Search Medicine Field -->
            <div class="form-group position-relative">
                <label for="medicine_name">Medicine Name</label>
                <input type="text" class="form-control" id="medicine-search" placeholder="Search for a medicine" required>
                <ul id="medicine-suggestions" class="list-group" style="display: none; position: absolute; width: 100%; z-index: 1000;"></ul>
                <input type="hidden" id="medicine_id" name="medicine_id">
            </div>



            <!-- Quantity Field -->
            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="number" class="form-control" id="quantity" name="quantity" required>
            </div>

            <!-- Unit Price Field -->
            <div class="form-group">
                <label for="unit_price">Unit Price:</label>
                <input type="number" class="form-control" id="unit_price" name="unit_price" step="0.01" required>
            </div>

            <!-- Sell Price Field -->
            <div class="form-group">
                <label for="sell_price">Sell Price:</label>
                <input type="number" class="form-control" id="sell_price" name="sell_price" step="0.01" required>
            </div>

            <!-- Unit Cost Field -->
            <div class="form-group">
                <label for="unit_cost">Unit Cost:</label>
                <input type="text" class="form-control" id="unit_cost" name="unit_cost" readonly>
            </div>

            <!-- Expiry Date Field -->
            <div class="form-group">
                <label for="expiry_date">Expiry Date:</label>
                <input type="date" class="form-control" id="expiry_date" name="expiry_date" required>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {

            // Search medicine using AJAX
            $('#medicine-search').on('keyup', function () {
                var query = $(this).val();
                if (query.length > 2) {  // Start searching after 3 characters
                    $.ajax({
                        url: "{{ route('medicines.search') }}",
                        type: "GET",
                        data: { query: query },
                        success: function (data) {
                            $('#medicine-suggestions').empty().show();
                            data.forEach(function (medicine) {
                                $('#medicine-suggestions').append(
                                    '<li class="list-group-item suggestion-item" data-id="' + medicine.id + '">' +
                                    '<strong>' + medicine.product_name + '</strong> ' +
                                    (medicine.generic_name ? '<span class="text-muted">(' + medicine.generic_name + ')</span>' : '  ') +
                                    (medicine.category ? ' <span class="text-info">[' + medicine.category + ']</span>' : '  ') +
                                    '</li>'
                                );
                            });

                        }
                    });
                } else {
                    $('#medicine-suggestions').hide();
                }
            });

            // When a suggestion is clicked, populate the input and hide suggestions
            $(document).on('click', '.suggestion-item', function () {
                var selectedMedicine = $(this).text();
                var medicineId = $(this).data('id');
                $('#medicine-search').val(selectedMedicine);
                $('#medicine_id').val(medicineId);
                $('#medicine-suggestions').hide();
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

            // Close suggestions if clicked outside
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
