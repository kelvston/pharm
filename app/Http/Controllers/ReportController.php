<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function salesReport(Request $request)
    {
        $startDate = $request->input('start_date', now()->subMonth()); // Default to the past month
        $endDate = $request->input('end_date', now()); // Default to today

        // Total Sales
        $totalSales = DB::table('sales')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum(DB::raw('total_amount'));

        // Total Expenses
        $totalExpenses = DB::table('expenses')
            ->whereBetween('expense_date', [$startDate, $endDate])
            ->sum(DB::raw('amount'));

        // Net Profit
        $netProfit = $totalSales - $totalExpenses;

        // Sales by Medication
        $salesByMedication = DB::table('sales')
            ->join('medicine_list', 'sales.medicine_id', '=', 'medicine_list.id')
            ->join('medicines', 'sales.medicine_id', '=', 'medicines.medicine_id')
            ->whereBetween('sales.created_at', [$startDate, $endDate])
            ->select(
                'medicine_list.product_name',
                DB::raw('SUM(sales.quantity) as total_quantity'),
                DB::raw('SUM(sales.total_amount) as total_sales'),
                DB::raw('SUM(sales.quantity * medicines.unit_price) as total_cost'),
                DB::raw('SUM(sales.total_amount) - SUM(sales.quantity * medicines.unit_price) as profit'),
                DB::raw('CASE WHEN SUM(sales.quantity * medicines.unit_price) > 0 THEN ROUND(((SUM(sales.total_amount) - SUM(sales.quantity * medicines.unit_price)) / SUM(sales.quantity * medicines.unit_price)) * 100, 2) ELSE 0 END as percentage_profit')
            )
            ->groupBy('medicine_list.product_name')
            ->get();

        // Sales Trends (Daily)
        $salesTrends = DB::table('sales')
            ->select(DB::raw('DATE(created_at) as sale_date'), DB::raw('SUM(total_amount) as daily_sales'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->get();

        // Expenses Breakdown (Category-wise)
        $expensesByCategory = DB::table('expenses')
            ->whereBetween('expense_date', [$startDate, $endDate])
            ->select('category', DB::raw('SUM(amount) as total_amount'))
            ->groupBy('category')
            ->get();

        return view('reports.sales', compact('totalSales', 'totalExpenses', 'netProfit', 'salesByMedication', 'salesTrends', 'expensesByCategory'));
    }


    public function inventoryReport()
    {

        // Current Stock Levels
        $stockLevels = DB::table('medicines')->join('medicine_list','medicine_list.id','=','medicines.medicine_id')->select('product_name', 'quantity')->get();

        // Expired Medications
        $expiredMedications = DB::table('medicines')
            ->join('medicine_list','medicine_list.id','=','medicines.medicine_id')
            ->where('expiry_date', '<', now())
            ->select('product_name', 'expiry_date')
            ->get();

        // Low Stock Alerts (Stock < 10)
        $lowStock = DB::table('medicines')
            ->join('medicine_list','medicine_list.id','=','medicines.medicine_id')
            ->where('quantity', '<', 10)
            ->select('product_name', 'quantity')
            ->get();

        return view('reports.inventory', compact('stockLevels', 'expiredMedications', 'lowStock'));
    }
    public function revenueReport(Request $request)
    {
        $startDate = $request->input('start_date', now()->subMonth()); // Default to the past month
        $endDate = $request->input('end_date', now()); // Default to today

        // Total Revenue
        $totalRevenue = DB::table('sales')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum(DB::raw('total_amount'));

        // Total Expenses
        $totalExpenses = DB::table('expenses')
            ->whereBetween('expense_date', [$startDate, $endDate])
            ->sum(DB::raw('amount'));

        // COGS (Cost of Goods Sold)
        $cogs = DB::table('sales')
            ->join('medicines', 'sales.medicine_id', '=', 'medicines.medicine_id')
            ->sum(DB::raw('unit_price * sales.quantity'));

        // Net Profit
        $netProfit = $totalRevenue - $cogs - $totalExpenses;

        // Profit Margin
        $profitMargin = $totalRevenue > 0 ? ($netProfit / $totalRevenue) * 100 : 0;

        return view('reports.revenue', compact('totalRevenue', 'totalExpenses', 'cogs', 'netProfit', 'profitMargin'));
    }


    public function checkLowStock()
    {
         $lowStockItems = DB::table('medicines')
            ->join('medicine_list','medicine_list.id','=','medicines.medicine_id')
            ->where('quantity', '<', 10)
            ->select('product_name', 'quantity')
            ->get();
        foreach ($lowStockItems as $item) {
            // Notify admin (or relevant user)
            User::find(Auth()->id())->notify(new LowStockAlert($item));
        }
    }


}
