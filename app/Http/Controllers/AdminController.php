<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $orders = Order::latest()->get(); // atau batasi jika terlalu banyak
        return view('admin.dashboard', compact('orders'));
    }
}
