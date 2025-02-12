<tbody>
@foreach ($medicines as $index => $medicine)
    <tr>
        <td>{{ $loop->iteration }}</td>
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
