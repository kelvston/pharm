@extends('layouts.app')

@section('title', 'Inventory')

@section('content')
    @php
        $i = 1;
    @endphp
    <div class="container mt-4 custom-bg" >
        <!-- Heading -->
        <h1 class="text-center mb-4">List of Medicines</h1>

        <!-- Search Form -->
        <form action="#" method="GET" class="mb-3" id="searchForm">
            <div class="input-group">
                <input type="text" name="search" id="medicine-search" class="form-control medicine-search" placeholder="Search..." value="{{ request('search') }}">
{{--                <div class="medicine-suggestions list-group position-absolute mt-1" style="width: 100%; z-index: 1000; display: none;"></div>--}}
            </div>
        </form>

        <!-- Medicines Table -->
        <div class="card mt-3">
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>S/N</th> <!-- Serial Number -->
                        <th>Product Name</th>
                        <th>Generic Name</th>
                        <th>Category</th>
                        <th>Barcode</th>
                    </tr>
                    </thead>
                    <tbody id="medicineTable">
                    @foreach ($medicines as $index => $medicine)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $medicine->product_name }}</td>
                            <td>{{ $medicine->generic_name }}</td>
                            <td>{{ $medicine->category }}</td>
                            <td>
                                @if ($medicine->barcode_image)
                                    <img src="{{ asset('storage/' . $medicine->barcode_image) }}" alt="Barcode for {{ $medicine->product_name }}" width="100">
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination Links (added below the table) -->
        {{ $medicines->links('pagination::bootstrap-5') }}
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
