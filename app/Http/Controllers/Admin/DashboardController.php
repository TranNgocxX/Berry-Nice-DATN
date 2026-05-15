<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Service;
use App\Services\BookingService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    // Dashboard tổng quan: thống kê số lượng lịch hẹn theo trạng thái + top dịch vụ được đặt nhiều nhất
    public function index(Request $request)
    {
        $status = $request->input('status', 'all');

        $appointments = Appointment::with(['detail', 'service'])
            ->when($status !== 'all', function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->orderByDesc('start_time')
            ->paginate(10)
            ->withQueryString();

        // Thống kê số lượng theo trạng thái
        $status = [
            'total'     => Appointment::count(),
            'pending'   => Appointment::where('status', 'pending')->count(),
            'confirmed' => Appointment::where('status', 'confirmed')->count(),
            'cancelled' => Appointment::where('status', 'cancelled')->count(),
            'paid'      => Appointment::where('payment_status', 'paid')->count(),
            'unpaid'    => Appointment::where('payment_status', 'unpaid')->count(),
        ];

        // Top dịch vụ
        $topServices = $this->bookingService->getTopServices(5);

        return view('admin.dashboard', array_merge($status, [
            'appointments' => $appointments,
            'status'       => $status,
            'topServices'  => $topServices
        ]));
    }

    public function search(Request $request)
    {
        $keyword = $request->keyword;

        $services = Service::where('name', 'like', "%$keyword%")
            ->orWhere('description', 'like', "%$keyword%")
            ->get();

        return view('admin.services.index', compact('services', 'keyword'));
    }
}
