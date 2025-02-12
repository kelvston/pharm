@extends('layouts.app') <!-- Ensures this view extends the base layout -->

@section('content')
    <div class="container custom-bg">
        <h1>Stock Taking</h1>
        <form action="{{ route('stock.take.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="medicine_search">Search Medicine:</label>
                <input type="text" id="medicine_search" class="form-control" placeholder="Type medicine name..." autocomplete="off" required>
                <input type="hidden" name="medicine_id" id="medicine_id"> <!-- Hidden field to store selected medicine ID -->
                <div id="medicine_search_results" class="list-group mt-2" style="display: none; max-height: 200px; overflow-y: auto;">
                    <!-- Search results will be appended here -->
                </div>
            </div>

            <div class="form-group">
                <label for="physical_quantity">Physical Quantity:</label>
                <input type="number" name="physical_quantity" id="physical_quantity" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="notes">Notes (optional):</label>
                <textarea name="notes" id="notes" class="form-control"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Record Stock Take</button>
        </form>
    </div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>


<script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
<script>

        $(document).ready(function () {

            const $searchInput = $('#medicine_search');
            const $searchResults = $('#medicine_search_results');
            const $medicineIdInput = $('#medicine_id');

            // Handle input event for searching
            $searchInput.on('input', function () {
                const query = $(this).val().trim();

                if (query.length > 2) { // Minimum 2 characters to trigger search
                    $.ajax({
                        url: '{{ route('stock.search') }}',
                        type: 'GET',
                        data: { q: query },
                        success: function (data) {
                            console.log(data); // Log the response data to see its structure
                            if (Array.isArray(data)) { // Check if data is an array
                                $searchResults.empty().show();
                                if (data.length) {
                                    data.forEach(function (medicines) {
                                        $searchResults.append(
                                            `<a href="#" class="list-group-item list-group-item-action" data-id="${medicines.id}">${medicines.product_name}</a>`
                                        );
                                    });
                                } else {
                                    $searchResults.append('<p class="list-group-item">No results found.</p>');
                                }
                            } else {
                                console.error('Expected array but got:', data); // Log unexpected response
                            }
                        },
                    });
                } else {
                    $searchResults.hide().empty();
                }
            });

            // Handle result click
            $searchResults.on('click', '.list-group-item', function (e) {
                e.preventDefault();
                const medicineName = $(this).text();
                const medicineId = $(this).data('id');

                $searchInput.val(medicineName);
                $medicineIdInput.val(medicineId);
                $searchResults.hide().empty();
            });

            // Hide search results if clicked outside
            $(document).on('click', function (e) {
                if (!$(e.target).closest('#medicine_search, #medicine_search_results').length) {
                    $searchResults.hide();
                }
            });
        });
    </script>
@endsection
