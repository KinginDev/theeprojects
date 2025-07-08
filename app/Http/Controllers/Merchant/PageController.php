<?php

namespace App\Http\Controllers\Merchant;

use Illuminate\Support\Str;
use App\Models\MerchantPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function index()
    {
        $pages = MerchantPage::where('merchant_id', Auth::guard('merchant')->id())
            ->orderBy('title')
            ->paginate(10);

        return view('merchant-layout.cms.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('merchant-layout.cms.pages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'nullable',
            'is_published' => 'boolean',
            'is_home' => 'boolean',
            'template' => 'required|string',
        ]);

        // Begin a database transaction
        DB::beginTransaction();

        try {
            $merchantId = Auth::guard('merchant')->id();

            // If this page will be the home page, unset any existing home page
            if ($request->input('is_home')) {
                MerchantPage::where('merchant_id', $merchantId)
                    ->where('is_home', true)
                    ->update(['is_home' => false]);
            }

            $slug = $request->input('slug') ?: Str::slug($request->input('title'));

            // Check if slug is unique for this merchant
            $exists = MerchantPage::where('merchant_id', $merchantId)
                ->where('slug', $slug)
                ->exists();

            if ($exists) {
                $slug = $slug . '-' . time();
            }

            $page = MerchantPage::create([
                'merchant_id' => $merchantId,
                'title' => $request->input('title'),
                'slug' => $slug,
                'content' => $request->input('content'),
                'is_published' => $request->input('is_published', false),
                'is_home' => $request->input('is_home', false),
                'template' => $request->input('template', 'default'),
                'meta_data' => [
                    'description' => $request->input('meta_description'),
                    'keywords' => $request->input('meta_keywords'),
                ],
            ]);

            DB::commit();

            return redirect()->route('merchant.pages.index')
                ->with('success', 'Page created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()
                ->with('error', 'An error occurred while creating the page: ' . $e->getMessage());
        }
    }

    public function edit(MerchantPage $page)
    {
        // Check ownership
        if ($page->merchant_id !== Auth::guard('merchant')->id()) {
            abort(403);
        }

        return view('merchant-layout.cms.pages.edit', compact('page'));
    }

    public function update(Request $request, MerchantPage $page)
    {
       // Check ownership
        if ($page->merchant_id !== Auth::guard('merchant')->id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|max:255',
            'content' => 'nullable',
            'is_published' => 'boolean',
            'is_home' => 'boolean',
            'template' => 'required|string',
        ]);

        // Begin a database transaction
        DB::beginTransaction();

        try {
            $merchantId = Auth::guard('merchant')->id();

            // If this page will be the home page, unset any existing home page
            if ($request->input('is_home')) {
                MerchantPage::where('merchant_id', $merchantId)
                    ->where('is_home', true)
                    ->where('id', '!=', $page->id) // Don't update this page
                    ->update(['is_home' => false]);
            }

            $slug = $request->input('slug') ?: Str::slug($request->input('title'));

            // Check if slug is unique for this merchant (except for this page)
            $exists = MerchantPage::where('merchant_id', $merchantId)
                ->where('slug', $slug)
                ->where('id', '!=', $page->id)
                ->exists();

            if ($exists) {
                $slug = $slug . '-' . time();
            }

            $page->update([
                'title' => $request->input('title'),
                'slug' => $slug,
                'content' => $request->input('content'),
                'is_published' => $request->input('is_published', false),
                'is_home' => $request->input('is_home', false),
                'template' => $request->input('template', 'default'),
                'meta_data' => [
                    'description' => $request->input('meta_description'),
                    'keywords' => $request->input('meta_keywords'),
                ],
            ]);

            DB::commit();

            return redirect()->route('merchant.pages.index')
                ->with('success', 'Page updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withInput()
                ->with('error', 'An error occurred while updating the page: ' . $e->getMessage());
        }
    }

    public function destroy(MerchantPage $page)
    {
        // Check ownership
        if ($page->merchant_id !== Auth::guard('merchant')->id()) {
            abort(403);
        }

        $page->delete();

        return redirect()->route('merchant.pages.index')
            ->with('success', 'Page deleted successfully.');
    }
}
