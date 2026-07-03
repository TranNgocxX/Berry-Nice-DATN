<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(
        protected DashboardService $dashboardService
    ) {}

    public function index(Request $request)
    {
        // Lấy period (mặc định là week) và date (mặc định là null)
        $period = $request->query('period', 'week');
        $date = $request->query('date'); 

        // Gọi service thông qua $this->dashboardService
        $data = $this->dashboardService->getDashboardData($period, $date);

        return view('admin.dashboard.index', $data);
    }
}