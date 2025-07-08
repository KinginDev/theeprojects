<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\MerchantPage;
use App\Classes\Helper;

class PageController extends Controller
{

    public function index()
    {
        $merchant = Helper::merchant();

        if (!$merchant) {
            abort(404);
        }

        // Get all published pages for the merchant
        // Try to get the designated home page
        $page = MerchantPage::getHomePage($merchant->id);

        // If no home page is set, get the first published page or show a default view
        if (!$page) {
            $page = MerchantPage::where('merchant_id', $merchant->id)
                ->where('is_published', true)
                ->orderBy('created_at')
                ->first();

            // If there are no pages at all, show a default view
            if (!$page) {
                // Get menus for the layout
                $headerMenu = $merchant->menus()->where('location', 'header')->where('is_active', true)->first();
                $footerMenu = $merchant->menus()->where('location', 'footer')->where('is_active', true)->first();

                return view('merchant-layout.cms.default-home', compact('merchant', 'headerMenu', 'footerMenu'));
            }
        }

        // Get the template specified in the page, or use 'default'
        $template = $page->template ?? 'default';

        // Build view path to the template layout
        $viewPath = "merchant-layout.cms.themes.{$merchant->theme}.templates.{$template}";

        // Fallback to default template if specific template doesn't exist
        if (!view()->exists($viewPath)) {
            $viewPath = "merchant-layout.cms.themes.{$merchant->theme}.templates.default";

            // Final fallback to a generic template
            if (!view()->exists($viewPath)) {
                $viewPath = "merchant-layout.cms.templates.default";
            }
        }

        // Get active menus for the merchant
        $headerMenu = $merchant->menus()->where('location', 'header')->where('is_active', true)->first();
        $footerMenu = $merchant->menus()->where('location', 'footer')->where('is_active', true)->first();


       return view($viewPath, compact('page', 'merchant', 'headerMenu', 'footerMenu'));
    }

    public function show($slug)
    {
        $merchant = Helper::merchant();

        if (!$merchant) {
            abort(404);
        }

        $page = MerchantPage::where('merchant_id', $merchant->id)
            ->where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        // Get the template specified in the page, or use 'default'
        $template = $page->template ?? 'default';

        // Build view path to the template layout
        $viewPath = "merchant-layout.cms.themes.{$merchant->theme}.templates.{$template}";

        // Fallback to default template if specific template doesn't exist
        if (!view()->exists($viewPath)) {
            $viewPath = "merchant-layout.cms.themes.{$merchant->theme}.templates.default";

            // Final fallback to a generic template
            if (!view()->exists($viewPath)) {
                $viewPath = "merchant-layout.cms.templates.default";
            }
        }

        // Get active menus for the merchant
        $headerMenu = $merchant->menus()->where('location', 'header')->where('is_active', true)->first();
        $footerMenu = $merchant->menus()->where('location', 'footer')->where('is_active', true)->first();

        return view($viewPath, compact('page', 'merchant', 'headerMenu', 'footerMenu'));
    }
}
