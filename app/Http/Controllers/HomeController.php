<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Sale;
use App\Purchase;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalSales = Sale::count();
        $totalRevenue = Sale::sum('total');
        
        // Peringatan Stok Menipis (stok <= 5)
        $lowStockProducts = Product::where('stock', '<=', 5)->get();

        // Data Grafik Penjualan 7 Hari Terakhir
        $chartDates = [];
        $chartTotals = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $chartDates[] = date('d M', strtotime($date));

            $total = Sale::whereDate('sold_at', $date)->sum('total');
            $chartTotals[] = $total;
        }

        return view('home', compact(
            'totalProducts', 
            'totalSales', 
            'totalRevenue', 
            'lowStockProducts', 
            'chartDates', 
            'chartTotals'
        ));
    }
}