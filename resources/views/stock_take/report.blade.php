<h1>Stock Take Report</h1>
<table>
    <thead>
    <tr>
        <th>Medicine</th>
        <th>Physical Quantity</th>
        <th>System Quantity</th>
        <th>Discrepancy</th>
        <th>Notes</th>
        <th>Date</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($stockTakes as $stockTake)
        <tr>
            <td>{{ $stockTake->medicine->medicineList->name }}</td>
            <td>{{ $stockTake->physical_quantity }}</td>
            <td>{{ $stockTake->system_quantity }}</td>
            <td>{{ $stockTake->discrepancy }}</td>
            <td>{{ $stockTake->notes }}</td>
            <td>{{ $stockTake->created_at->format('Y-m-d') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
