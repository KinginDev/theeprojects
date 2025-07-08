<?php

namespace App\Http\Controllers\Merchant;

use App\Models\MerchantMenu;
use App\Models\MerchantPage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    public function index()
    {
        $menus = MerchantMenu::where('merchant_id', Auth::guard('merchant')->id())
            ->orderBy('name')
            ->paginate(10);
            $locations = ['header', 'footer', 'sidebar'];
        return view('merchant-layout.cms.menus.create', compact('menus', 'locations'));
    }

    public function create()
    {
        $locations = ['header', 'footer', 'sidebar'];
        $menus = MerchantMenu::where('merchant_id', Auth::guard('merchant')->id())
            ->orderBy('name')
            ->paginate(10);
        return view('merchant-layout.cms.menus.create', compact('locations', 'menus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'location' => 'required|string',
            'is_active' => 'boolean',
        ]);

        // Check if menu name is unique for this merchant
        $exists = MerchantMenu::where('merchant_id', Auth::guard('merchant')->id())
            ->where('name', $request->input('name'))
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors(['name' => 'You already have a menu with this name.']);
        }

        $menu = MerchantMenu::create([
            'merchant_id' => Auth::guard('merchant')->id(),
            'name' => $request->input('name'),
            'location' => $request->input('location'),
            'is_active' => $request->input('is_active', true),
        ]);

        return redirect()->route('merchant.menus.index', $menu->id)
            ->with('success', 'Menu created successfully. Now add some items to it.');
    }

    public function edit(MerchantMenu $menu)
    {
        // Check ownership
        if ($menu->merchant_id !== Auth::guard('merchant')->id()) {
            abort(403);
        }

        $locations = ['header', 'footer', 'sidebar'];
        $pages = MerchantPage::where('merchant_id', Auth::guard('merchant')->id())
            ->where('is_published', true)
            ->orderBy('title')
            ->get();

        $menuItems = $menu->getTree();

        return view('merchant-layout.cms.menus.edit', compact('menu', 'locations', 'pages', 'menuItems'));
    }

    public function update(Request $request, MerchantMenu $menu)
    {
        // Check ownership
        if ($menu->merchant_id !== Auth::guard('merchant')->id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|max:255',
            'location' => 'required|string',
            'is_active' => 'boolean',
        ]);

        // Check if menu name is unique for this merchant (except for this menu)
        $exists = MerchantMenu::where('merchant_id', Auth::guard('merchant')->id())
            ->where('name', $request->input('name'))
            ->where('id', '!=', $menu->id)
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors(['name' => 'You already have a menu with this name.']);
        }

        $menu->update([
            'name' => $request->input('name'),
            'location' => $request->input('location'),
            'is_active' => $request->input('is_active', true),
        ]);

        return redirect()->route('merchant.menus.edit', $menu->id)
            ->with('success', 'Menu updated successfully.');
    }

    public function destroy(MerchantMenu $menu)
    {
        // Check ownership
        if ($menu->merchant_id !== Auth::guard('merchant')->id()) {
            abort(403);
        }

        $menu->delete();

        return redirect()->route('merchant.menus.index')
            ->with('success', 'Menu deleted successfully.');
    }
}
