<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sales = Sale::with('staff')->latest()->paginate(10);
        return view('sales.index', compact('sales'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sales.create');
    }


    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $request->validate([
            'orders' => 'required|array',
            'orders.*.medicine_id' => 'required|string|max:255',
            'orders.*.quantity' => 'required|numeric|min:1',
        ]);

        try {
            DB::transaction(function () use ($request) {
                foreach ($request->orders as $order) {
                    $medicine = Medicine::where('medicine_id', $order['medicine_id'])->first();

                    if (!$medicine) {
                        throw new \Exception("Medicine with ID {$order['medicine_id']} not found.");
                    }

                    if ($medicine->quantity < $order['quantity']) {
                        throw new \Exception("Insufficient stock for Medicine ID {$order['medicine_id']}.");
                    }

                    $remain = $medicine->quantity - $order['quantity'];
                    $total_amount = $order['quantity'] * $medicine->sell_price;
                    $batchNumber = Sale::count() + 1;

                    Sale::create([
                        'staff_id' => auth()->id(),
                        'medicine_id' => $order['medicine_id'],
                        'batch_number' => $batchNumber,
                        'quantity' => $order['quantity'],
                        'total_amount' => $total_amount,
                    ]);

                    $medicine->update(['quantity' => $remain]);
                }
            });

            session()->flash('success', 'Sales added successfully!'); // Ensure the message is flashed
            return redirect()->route('sales.index');
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage()); // Ensure error message is flashed
            return redirect()->route('sales.index');
        }
    }




    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $sale = Sale::with('staff')->findOrFail($id);
        return view('sales.show', compact('sale'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $sale = Sale::findOrFail($id);
        return view('sales.edit', compact('sale'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_name' => 'nullable|string|max:255',
            'total_amount' => 'required|numeric|min:0',
        ]);

        $sale = Sale::findOrFail($id);
        $sale->update($request->only('customer_name', 'total_amount'));

        return redirect()->route('sales.index')->with('success', 'Sale updated successfully!');
    }


    /**
     * Update the specified resource in storage.
     */


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Sale::destroy($id);
        return redirect()->route('sales.index')->with('success', 'Sale deleted successfully!');
    }

}
