<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $count = Produk::count();
        
        return view('dashboard.dashboard', [
            'count' => $count
        ]);
    }
}
