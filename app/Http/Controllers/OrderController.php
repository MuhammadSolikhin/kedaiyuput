<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('items')->latest()->paginate(10);
        return view('admin.order.index', compact('orders'));
    }

    public function confirm($id)
    {
        $order = Order::findOrFail($id);
        $order->payment_status = 'paid';
        $order->paid_at = now();
        $order->save();

        return redirect()->route('orders.index')->with('success', 'Pembayaran telah dikonfirmasi.');
    }

}
