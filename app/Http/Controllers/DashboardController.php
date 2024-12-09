<?php
namespace App\Http\Controllers;

use App\Models\Medication;
use App\Models\Medicine;
use App\Models\Sale;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMedications = Medicine::count();
        $totalSalesToday = Sale::whereDate('created_at', Carbon::today())->sum('total_amount');
        $lowStockMedications = Medicine::where('quantity', '<', 10)->get();
        $expiringSoon = Medicine::where('expiry_date', '<', Carbon::today()->addDays(30))->get();

        return view('dashboard.index', compact(
            'totalMedications',
            'totalSalesToday',
            'lowStockMedications',
            'expiringSoon',
        ));
    }
}

