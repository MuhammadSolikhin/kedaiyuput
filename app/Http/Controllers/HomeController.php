<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Menu;
use App\Models\MenuCategory;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $categories = MenuCategory::with([
            'menus' => function ($query) {
                $query->where('is_available', true);
            }
        ])->get();

        return view('homepage', compact('categories'));
    }

    public function cart()
    {
        $tables = Table::all();
        return view('user.cart', compact('tables'));
    }

    public function checkout()
    {
        return view('user.checkout');
    }

    public function confirm(Request $request)
    {
        $cart = Cart::create([
            'user_id' => Auth::id(),
            'table_number' => $request->table_number,
            'is_checked_out' => 1,
        ]);

        foreach ($request->items as $item) {
            $menu = Menu::find($item['id']);

            if (!$menu) {
                return response()->json(['success' => false, 'message' => 'Menu tidak ditemukan'], 404);
            }

            CartItem::create([
                'cart_id' => $cart->id,
                'menu_id' => $menu->id,
                'quantity' => $item['jumlah'],
                'note' => $item['note'] ?? null,
            ]);
        }

        $order = Order::create([
            'user_id' => Auth::id(),
            'table_number' => $request->table_number,
            'cart_id' => $cart->id,
            'total_price' => $request->total,
            'payment_method' => in_array($request->payment_method, ['cash']) ? 'cash' : 'transfer',
            'payment_status' => 'pending',
        ]);

        foreach ($request->items as $item) {
            $menu = Menu::find($item['id']);

            OrderItem::create([
                'order_id' => $order->id,
                'menu_id' => $menu->id,
                'name_snapshot' => $menu->name,
                'price_snapshot' => $menu->price,
                'quantity' => $item['jumlah'],
                'note' => $item['note'] ?? null,
            ]);
        }

        return response()->json(['success' => true, 'order_id' => $order->id]);
    }

}
