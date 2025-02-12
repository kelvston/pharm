@extends('layouts.app')

@section('content')
    <div class="container custom-bg">
        <h1>Add Expense</h1>
        <form action="{{ route('expenses.store') }}" method="POST">
            @csrf
            <div class="form-group position-relative mb-3 ">
                <label for="title">Title</label>
                <input type="text" name="title" class="form-control" required>
            </div>
            <div class="form-group position-relative mb-3">
                <label for="amount">Amount</label>
                <input type="number" name="amount" step="0.01" class="form-control" required>
            </div>
            <div class="form-group position-relative mb-3">
                <label for="expense_date">Date</label>
                <input type="date" name="expense_date" class="form-control" required>
            </div>
            <div class="form-group position-relative mb-3">
                <label for="category">Category</label>
                <select name="category" id="category" class="form-control" required>
                    <option value="" disabled selected>Select Category</option>
                    <option value="Utilities">Electricity</option>
                    <option value="Salaries">Food</option>
                    <option value="Rent">Rent</option>
                    <option value="Supplies">TRA</option>
                    <option value="Miscellaneous">Other</option>
                </select>
            </div>
            <div class="form-group position-relative mb-3" id="custom-category-group" style="display: none;">
                <label for="custom_category">Specify Category</label>
                <input type="text" name="custom_category" id="custom_category" class="form-control" placeholder="Specify custom category">
            </div>
            <div class="form-group position-relative mb-3">
                <label for="description">Description</label>
                <textarea name="description" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-success">Save Expense</button>
        </form>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const categorySelect = document.getElementById('category');
            const customCategoryGroup = document.getElementById('custom-category-group');
            const customCategoryInput = document.getElementById('custom_category');

            categorySelect.addEventListener('change', function () {
                if (categorySelect.value === 'Miscellaneous') {
                    customCategoryGroup.style.display = 'block';
                    customCategoryInput.required = true;
                } else {
                    customCategoryGroup.style.display = 'none';
                    customCategoryInput.required = false;
                    customCategoryInput.value = ''; // Clear input if hidden
                }
            });
        });
    </script>
@endsection
