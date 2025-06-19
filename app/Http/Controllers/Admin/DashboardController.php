<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // You can fetch any necessary data for the dashboard here
        // For example, statistics, recent activities, etc.

        return view('admin-layout.dashboard.index');
    }
}
