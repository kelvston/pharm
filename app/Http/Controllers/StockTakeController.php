<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\StockTake;
use Illuminate\Http\Request;

class StockTakeController extends Controller
{
    public function index()
    {
        $medicines = Medicine::join('medicine_list', 'medicine_list.id', '=', 'medicines.medicine_id')->get();
        return view('stock_take.index', compact('medicines'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'medicine_id' => 'required|exists:medicines,id',
            'physical_quantity' => 'required|integer|min:0',
            'notes' => 'nullable|string',
        ]);

        $medicine = Medicine::findOrFail($validated['medicine_id']);
        $systemQuantity = $medicine->quantity;

        $stockTake = StockTake::create([
            'medicine_id' => $validated['medicine_id'],
            'physical_quantity' => $validated['physical_quantity'],
            'system_quantity' => $systemQuantity,
            'discrepancy' => $validated['physical_quantity'] - $systemQuantity,
            'notes' => $validated['notes'] ?? null,
        ]);

        $medicine->last_stock_take_at = now();
        $medicine->save();

        return back()->with('success', 'Stock take recorded successfully.');
    }

    public function report()
    {
        $stockTakes = StockTake::with('medicine')->get();
        return view('stock_take.report', compact('stockTakes'));
    }
}
