<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $data = Produk::orderBy('name','ASC')->get();
        
        return view('home.home', [
            'data' => $data
        ]);
    }
}
