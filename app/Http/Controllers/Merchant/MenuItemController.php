<?php


namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\MerchantMenu;
use App\Models\MerchantMenuItem;
use App\Models\MerchantPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuItemController extends Controller
{
    public function store(Request $request, MerchantMenu $menu)
    {
        // Check ownership
        if ($menu->merchant_id !== Auth::guard('merchant')->id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|max:255',
            'url' => 'nullable|url',
            'page_id' => 'nullable|exists:merchant_pages,id',
            'parent_id' => 'nullable|exists:merchant_menu_items,id',
            'target' => 'required|in:_self,_blank',
            'is_active' => 'boolean',
        ]);

        // Get the next order value
        $maxOrder = MerchantMenuItem::where('menu_id', $menu->id)
            ->where('parent_id', $request->input('parent_id'))
            ->max('order') ?? 0;

        MerchantMenuItem::create([
            'menu_id' => $menu->id,
            'parent_id' => $request->input('parent_id'),
            'title' => $request->input('title'),
            'url' => $request->input('url'),
            'page_id' => $request->input('page_id'),
            'order' => $maxOrder + 1,
            'target' => $request->input('target', '_self'),
            'is_active' => $request->input('is_active', true),
        ]);

        return redirect()->route('merchant.menus.edit', $menu->id)
            ->with('success', 'Menu item added successfully.');
    }

    public function update(Request $request, MerchantMenuItem $menuItem)
    {
        // Check ownership
        if ($menuItem->menu->merchant_id !== Auth::guard('merchant')->id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|max:255',
            'url' => 'nullable|url',
            'page_id' => 'nullable|exists:merchant_pages,id',
            'parent_id' => 'nullable|exists:merchant_menu_items,id',
            'target' => 'required|in:_self,_blank',
            'is_active' => 'boolean',
        ]);

        // Ensure we're not setting the item as its own parent
        if ($request->input('parent_id') == $menuItem->id) {
            return back()->withErrors(['parent_id' => 'A menu item cannot be its own parent.']);
        }

        $menuItem->update([
            'parent_id' => $request->input('parent_id'),
            'title' => $request->input('title'),
            'url' => $request->input('url'),
            'page_id' => $request->input('page_id'),
            'target' => $request->input('target', '_self'),
            'is_active' => $request->input('is_active', true),
        ]);

        return redirect()->route('merchant.menus.edit', $menuItem->menu_id)
            ->with('success', 'Menu item updated successfully.');
    }

    public function destroy(MerchantMenuItem $menuItem)
    {
        // Check ownership
        if ($menuItem->menu->merchant_id !== Auth::guard('merchant')->id()) {
            abort(403);
        }

        $menu_id = $menuItem->menu_id;
        $menuItem->delete();

        return redirect()->route('merchant.menus.edit', $menu_id)
            ->with('success', 'Menu item deleted successfully.');
    }

    public function reorder(Request $request, MerchantMenu $menu)
    {
        // Check ownership
        if ($menu->merchant_id !== Auth::guard('merchant')->id()) {
            abort(403);
        }

        $request->validate([
            'items' => 'required|array',
            'items.*.id' => 'required|exists:merchant_menu_items,id',
            'items.*.parent_id' => 'nullable|exists:merchant_menu_items,id',
            'items.*.order' => 'required|integer|min:0',
        ]);

        foreach ($request->input('items') as $item) {
            $menuItem = MerchantMenuItem::find($item['id']);

            // Check that this menu item belongs to this menu
            if ($menuItem->menu_id !== $menu->id) {
                continue;
            }

            $menuItem->update([
                'parent_id' => $item['parent_id'],
                'order' => $item['order'],
            ]);
        }

        return response()->json(['success' => true]);
    }
}
