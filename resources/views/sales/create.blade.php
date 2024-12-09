{{--@extends('layouts.app')--}}

{{--@section('content')--}}
{{--    <div class="container">--}}
{{--        <h1>Add New Sale</h1>--}}
{{--        <form action="{{ route('sales.store') }}" method="POST">--}}
{{--            @csrf--}}
{{--            <div class="mb-3">--}}
{{--                <label for="medicine_name">Medicine Name</label>--}}
{{--                <input type="text" class="form-control" id="medicine-search" placeholder="Search for a medicine" required>--}}
{{--                <ul id="medicine-suggestions" class="list-group" style="display: none; position: absolute; width: 100%; z-index: 1000;"></ul>--}}
{{--                <input type="hidden" id="medicine_id" name="medicine_id">--}}
{{--            </div>--}}
{{--            <div class="mb-3">--}}
{{--                <label for="quantity" class="form-label">Quantity</label>--}}
{{--                <input type="number" name="quantity" id="quantity" class="form-control" step="0.01" value="{{ old('quantity') }}" required>--}}
{{--            </div>--}}
{{--            <button type="submit" class="btn btn-success">Sell</button>--}}
{{--            <a href="{{ route('sales.index') }}" class="btn btn-secondary">Cancel</a>--}}
{{--        </form>--}}
{{--    </div>--}}

{{--    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>--}}
{{--    <script>--}}
{{--        $(document).ready(function () {--}}

{{--            // Search medicine using AJAX--}}
{{--            $('#medicine-search').on('keyup', function () {--}}
{{--                var query = $(this).val();--}}
{{--                if (query.length > 2) {  // Start searching after 3 characters--}}
{{--                    $.ajax({--}}
{{--                        url: "{{ route('medicines.search_inventory') }}",--}}
{{--                        type: "GET",--}}
{{--                        data: { query: query },--}}
{{--                        success: function (data) {--}}
{{--                            $('#medicine-suggestions').empty().show();--}}
{{--                            data.forEach(function (medicine) {--}}
{{--                                $('#medicine-suggestions').append(--}}
{{--                                    '<li class="list-group-item suggestion-item" data-id="' + medicine.id + '">' +--}}
{{--                                    '<strong>' + medicine.product_name + '</strong> ' +--}}
{{--                                    (medicine.generic_name ? '<span class="text-muted">(' + medicine.generic_name + ')</span>' : '  ') +--}}
{{--                                    (medicine.category ? ' <span class="text-info">[' + medicine.category + ']</span>' : '  ') +--}}
{{--                                    '</li>'--}}
{{--                                );--}}
{{--                            });--}}

{{--                        }--}}
{{--                    });--}}
{{--                } else {--}}
{{--                    $('#medicine-suggestions').hide();--}}
{{--                }--}}
{{--            });--}}

{{--            // When a suggestion is clicked, populate the input and hide suggestions--}}
{{--            $(document).on('click', '.suggestion-item', function () {--}}
{{--                var selectedMedicine = $(this).text();--}}
{{--                var medicineId = $(this).data('id');--}}
{{--                $('#medicine-search').val(selectedMedicine);--}}
{{--                $('#medicine_id').val(medicineId);--}}
{{--                $('#medicine-suggestions').hide();--}}
{{--            });--}}

{{--            // Calculate unit cost based on quantity and unit price--}}
{{--            document.getElementById('quantity').addEventListener('input', updateUnitCost);--}}
{{--            document.getElementById('unit_price').addEventListener('input', updateUnitCost);--}}

{{--            function updateUnitCost() {--}}
{{--                var quantity = parseFloat(document.getElementById('quantity').value) || 0;--}}
{{--                var unitPrice = parseFloat(document.getElementById('unit_price').value) || 0;--}}
{{--                var unitCost = quantity * unitPrice;--}}
{{--                document.getElementById('unit_cost').value = unitCost.toFixed(2);--}}
{{--            }--}}

{{--            // Close suggestions if clicked outside--}}
{{--            $(document).mouseup(function (e) {--}}
{{--                var container = $("#medicine-suggestions");--}}
{{--                var searchBox = $("#medicine-search");--}}

{{--                if (!container.is(e.target) && !searchBox.is(e.target) && container.has(e.target).length === 0) {--}}
{{--                    container.hide();--}}
{{--                }--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}
{{--@endsection--}}


@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create New Sale</h1>
        <form action="{{ route('sales.store') }}" method="POST">
            @csrf

            <div id="order-list">
                <div class="order-item mb-3">
                    <div class="row">
                        <div class="col-md-5">
                            <label for="medicine-search">Medicine Name</label>
                            <input type="text" class="form-control medicine-search" placeholder="Search for a medicine" required>
                            <ul class="medicine-suggestions list-group" style="display: none; position: absolute; width: 100%; z-index: 1000;"></ul>
                            <input type="hidden" class="medicine-id" name="orders[0][medicine_id]">
                        </div>
                        <div class="col-md-3">
                            <label for="quantity">Quantity</label>
                            <input type="number" class="form-control quantity" name="orders[0][quantity]" step="1" required>
                        </div>
                        <div class="col-md-1 d-flex align-items-end">
                            <button type="button" class="btn btn-danger remove-order">Remove</button>
                        </div>
                    </div>
                </div>
            </div>

            <button type="button" id="add-order" class="btn btn-primary mb-3">Add Another Product</button>
            <button type="submit" class="btn btn-success">Sell</button>
            <a href="{{ route('sales.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            let orderIndex = 1;

            // Add new product order row
            $('#add-order').on('click', function () {
                const newOrder = `
            <div class="order-item mb-3">
                <div class="row">
                    <div class="col-md-5">
                        <label for="medicine-search">Medicine Name</label>
                        <input type="text" class="form-control medicine-search" placeholder="Search for a medicine" required>
                        <ul class="medicine-suggestions list-group" style="display: none; position: absolute; width: 100%; z-index: 1000;"></ul>
                        <input type="hidden" class="medicine-id" name="orders[${orderIndex}][medicine_id]">
                    </div>
                    <div class="col-md-3">
                        <label for="quantity">Quantity</label>
                        <input type="number" class="form-control quantity" name="orders[${orderIndex}][quantity]" step="1" required>
                    </div>

                    <div class="col-md-1 d-flex align-items-end">
                        <button type="button" class="btn btn-danger remove-order">Remove</button>
                    </div>
                </div>
            </div>`;
                $('#order-list').append(newOrder);
                orderIndex++;
            });

            // Remove a product order row
            $(document).on('click', '.remove-order', function () {
                $(this).closest('.order-item').remove();
            });

            // Medicine search using AJAX
            $(document).on('keyup', '.medicine-search', function () {
                const query = $(this).val();
                const suggestionsList = $(this).siblings('.medicine-suggestions');

                if (query.length > 2) {
                    $.ajax({
                        url: "{{ route('medicines.search_inventory') }}",
                        type: "GET",
                        data: { query: query },
                        success: function (data) {
                            suggestionsList.empty().show();
                            data.forEach(function (medicine) {
                                suggestionsList.append(`
                                <li class="list-group-item suggestion-item" data-id="${medicine.id}">
                                    <strong>${medicine.product_name}</strong>
                                    ${medicine.generic_name ? `<span class="text-muted">(${medicine.generic_name})</span>` : ''}
                                    ${medicine.category ? `<span class="text-info">[${medicine.category}]</span>` : ''}
                                </li>
                            `);
                            });
                        }
                    });
                } else {
                    suggestionsList.hide();
                }
            });

            // Select a medicine from suggestions
            $(document).on('click', '.suggestion-item', function () {
                const parent = $(this).closest('.order-item');
                parent.find('.medicine-search').val($(this).text());
                parent.find('.medicine-id').val($(this).data('id'));
                $(this).closest('.medicine-suggestions').hide();
            });

            // Close suggestions when clicking outside
            $(document).mouseup(function (e) {
                const container = $('.medicine-suggestions');
                if (!container.is(e.target) && container.has(e.target).length === 0) {
                    container.hide();
                }
            });
        });
    </script>
@endsection

