<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\MenuCategory;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::with('category')->latest()->paginate(10);
        return view('admin.menus.index', compact('menus'));
    }

    public function create()
    {
        $categories = MenuCategory::all();
        return view('admin.menus.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:menu_categories,id',
            'image_url' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_available' => 'boolean'
        ]);

        $data = $request->except('image_url');

        if ($request->hasFile('image_url')) {
            $data['image_url'] = $request->file('image_url')->store('menus', 'public');
        }

        Menu::create($data);
        return redirect()->route('menus.index')->with('success', 'Menu berhasil ditambahkan.');
    }

    public function edit(Menu $menu)
    {
        $categories = MenuCategory::all();
        return view('admin.menus.edit', compact('menu', 'categories'));
    }

    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:menu_categories,id',
            'image_url' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'is_available' => 'boolean'
        ]);

        $data = $request->except('image_url');

        if ($request->hasFile('image_url')) {
            $data['image_url'] = $request->file('image_url')->store('menus', 'public');
        }

        $menu->update($data);
        return redirect()->route('menus.index')->with('success', 'Menu berhasil diperbarui.');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect()->route('menus.index')->with('success', 'Menu berhasil dihapus.');
    }
}
