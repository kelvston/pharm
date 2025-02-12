<?php

namespace App\Imports;

use App\Models\Medicine;
use App\Models\MedicineList;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToCollection;
use Milon\Barcode\DNS1D;

class MedicinesImport implements ToCollection
{
    public function collection(Collection $rows)
    {

        foreach ($rows as $index => $row) {

            // Skip the header row
            if ($index === 0) {
                continue;
            }

            // Extract fields from the row
            $productName = $row[0]; // Product Name
            $genericName = $row[1]; // Generic Name
            $category = $row[2];    // Category
            $quantity = $row[3];    // Quantity
            $unitPrice = $row[4];   // Unit Price
            $sellPrice = $row[5];   // Sell Price
            $expiryDate = $row[6];  // Expiry Date (mm/dd/yyyy)
            $unitPrice = $row[4];   // Unit Price
//            $expiryDate = Carbon::createFromFormat('Y-m-d', $row[6])->toDateString();

            $expiryDate = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[6])->format('Y-m-d');

            // Step 1: Add or fetch from Medicine List



            $medicineList = MedicineList::firstOrCreate(
                ['product_name' => $productName], // Check by product_name
                [
                    'product_name' => $productName,
                    'generic_name' => $genericName,
                    'category' => $category,
                    'barcode_image' => null, //,
                ]
            );
            $medicineList->barcode_image = $this->generateBarcodeImage($medicineList->id);
            $unit_cost = $unitPrice * $quantity;
            // Step 2: Add details to Medicine Table
            $medicine = Medicine::create([
                'medicine_id' => $medicineList->id, // Link with Medicine List ID
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'sell_price' => $sellPrice,
                'unit_cost'=> $unit_cost,
                'barcode_image' => null,//$this->generateBarcodeImage($productName),
                'expiry_date' => $expiryDate,
            ]);

        }
    }

    private function generateBarcodeImage($medicine_list_id)
    {
//        $barcode = new DNS1D();
//        $barcodeImage = $barcode->getBarcodePNG($productName, 'C39');
//
//        $filename = \Illuminate\Support\Str::slug($productName) . '_' . time() . '.png';
//        Storage::disk('public')->put('barcodes/' . $filename, base64_decode($barcodeImage));
//        $barcodePath = 'barcodes/' . $filename;
//        return $barcodePath;

        $barcodeData = $medicine_list_id;
        $medicine = MedicineList::find($medicine_list_id);
        $barcode = new DNS1D();
        $barcodeImage = $barcode->getBarcodePNG($barcodeData, 'C39');

        $filename = \Illuminate\Support\Str::slug($medicine->product_name) . '_' . time() . '.png';

        // Store the image in the 'public/barcodes' directory
        Storage::disk('public')->put('barcodes/' . $filename, base64_decode($barcodeImage));

        // Save the barcode image path to the medicine model (optional)
        $medicine->barcode_image = 'barcodes/' . $filename;
        $medicine->save();

    }
}
