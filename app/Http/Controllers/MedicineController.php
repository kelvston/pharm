<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Medicine;
use App\Models\MedicineList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Milon\Barcode\DNS1D;
use Milon\Barcode\DNS2D;
use Psy\Util\Str;

class MedicineController extends Controller
{



    public function showBarcode($medicine_id)
    {

        $medicine = Medicine::where('medicine_id', $medicine_id)->first();

        // Ensure that there is at least one medicine in the list
        if ($medicine->medicinelist->isEmpty()) {
            // Handle case where no products exist (optional, maybe redirect or return an error)
            return redirect()->back()->with('error', 'No products found for this medicine.');
        }
        $barcodeData = $medicine->medicine_id;
        $barcode = new DNS1D();
        $barcodeImage = $barcode->getBarcodePNG($barcodeData, 'C39');

        $filename = \Illuminate\Support\Str::slug($medicine->medicinelist[0]->product_name) . '_' . time() . '.png';

        // Store the image in the 'public/barcodes' directory
        Storage::disk('public')->put('barcodes/' . $filename, base64_decode($barcodeImage));

        // Save the barcode image path to the medicine model (optional)
        $medicine->barcode_image = 'barcodes/' . $filename;
        $medicine->save();
        return view('inventory.barcode', compact('barcodeImage', 'medicine'));
    }





    public function index()
    {

        $medicines = Medicine::all();
        $medicines = Medicine::paginate(10);
        return view('inventory.index', compact('medicines'));
    }

    public function create()
    {
        $categories = Category::all();
        $medicines = Medicine::where('quantity', '>', 0)->pluck('medicine_id', 'id');
        return view('inventory.create', compact('categories','medicines'));
    }

    public function store(Request $request)
    {


        $request->validate([
            'medicine_id' => 'required',
            'quantity' => 'required|integer',
            'unit_price' => 'required|numeric',
            'sell_price' => 'required|numeric',
            'expiry_date' => 'required|date',
        ]);

        // Calculate unit cost (unit_price * quantity)
        $unit_cost = $request->unit_price * $request->quantity;

        // Store the medicine including unit_cost

        Medicine::create([
            'medicine_id' => $request->medicine_id,
            'quantity' => $request->quantity,
            'unit_price' => $request->unit_price,
            'sell_price' => $request->sell_price,
            'unit_cost' => $unit_cost,
            'expiry_date' => $request->expiry_date,
        ]);

        return redirect('/inventory')->with('success', 'Medicine added successfully!');
    }



    public function edit($id)
    {
        $medicine = Medicine::findOrFail($id);  // Find the medicine by its ID
        $categories = Category::all();  // Get all categories
        return view('inventory.edit', compact('medicine', 'categories'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'category' => 'required',
            'quantity' => 'required|integer',
            'price' => 'required|numeric',
            'expiry_date' => 'required|date',
        ]);

        $medicine = Medicine::findOrFail($id);
        $medicine->update($request->all());

        return redirect('/inventory')->with('success', 'Medicine updated successfully!');
    }

    public function destroy($id)
    {
        $medicine = Medicine::findOrFail($id);
        $medicine->delete();

        return redirect('/inventory')->with('success', 'Medicine deleted successfully!');
    }

    public function search(Request $request)
    {

        $query = $request->get('query');
//
//        $duplicates = DB::table('medicine_list')
//            ->select('product_name')
//            ->groupBy('product_name')
//            ->havingRaw('COUNT(*) > 1')
//            ->get();
//
//        foreach ($duplicates as $duplicate) {
//            $medicineIds = DB::table('medicine_list')
//                ->where('product_name', $duplicate->product_name)
//                ->orderBy('id') // Order by ID to keep the first record
//                ->pluck('id')
//                ->toArray();
//
//            // Remove all but the first occurrence
//            array_shift($medicineIds); // Remove the first entry (we want to keep it)
//
//            // Delete the duplicates
//            DB::table('medicine_list')->whereIn('id', $medicineIds)->delete();
//        }
//        $done = DB::table('medicine_list')
//            ->select('product_name')
//            ->groupBy('product_name')
//            ->havingRaw('COUNT(*) > 1')
//            ->get();
//dd($done);
        $medicines = DB::table('medicine_list')
            ->select('id', 'product_name', 'generic_name', 'category')
            ->where('product_name', 'ILIKE', '%' . $query . '%') // Case-insensitive match on product_name
            ->orWhere('generic_name', 'ILIKE', '%' . $query . '%') // Case-insensitive match on generic_name
            ->orderBy('product_name', 'ASC') // Order by product_name
            ->limit(12)
            ->get();






        return response()->json($medicines);
    }

    public function searchInventory(Request $request){

        $query = $request->get('query');
        $medicine_list = Medicine::pluck('medicine_id'); // Assuming you need only the IDs.

        $medicines = DB::table('medicine_list')
            ->select('id', 'product_name', 'generic_name', 'category')
            ->whereIn('id', $medicine_list)
            ->where(function ($queryBuilder) use ($query) {
                $queryBuilder->where('product_name', 'ILIKE', '%' . $query . '%')
                    ->orWhere('generic_name', 'ILIKE', '%' . $query . '%');
            })
            ->orderBy('product_name', 'ASC')
            ->limit(12)
            ->get();

        return response()->json($medicines);
    }

    public function processScan(Request $request)
    {
        $barcode = $request->input('barcode');
        dd($barcode);
        // Process the barcode, e.g., look up the product and update inventory
        return response()->json(['success' => true, 'barcode' => $barcode]);
    }


}
