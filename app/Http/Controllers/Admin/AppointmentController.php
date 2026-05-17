<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Services\BookingService;

class AppointmentController extends Controller
{

    protected $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }
    
    public function index(Request $request)
    {
        $appointments = Appointment::with(['user', 'service', 'employee', 'appointmentDetail'])
            ->filter($request->all()) // Áp dụng scope filter vừa tạo
            ->latest()
            ->paginate(10)
            ->withQueryString(); // Đảm bảo giữ lại các tham số lọc khi chuyển trang phân trang

        return view('admin.appointments.index', compact('appointments'));
    }

    // Xem chi tiết lịch hẹn + phân công nhân viên khi duyệt lịch
    public function show(Appointment $appointment)
    {
        $appointment->load([
            'user',
            'service',
            'appointmentDetail',
            'employee'
        ]);

        // chỉ lấy nhân viên làm được dịch vụ này + có thời gian rảnh vào khung giờ của lịch hẹn
        $employees = $this->bookingService->getEmployees($appointment);

        return view('admin.appointments.show', compact('appointment', 'employees'));
    }

    // phân công nhân viên khi duyệt lịch
    public function confirm(Request $request, Appointment $appointment)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id'
        ]);

        try {
            $this->bookingService->confirmAppointment(
                $appointment,
                $request->employee_id
            );

            return redirect()
                ->route('admin.appointments.index')
                ->with('success', 'Xác nhận lịch thành công');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    // Từ chối lịch
    public function reject(Appointment $appointment)
    {
        $appointment->update([
            'status' => 'rejected'
        ]);

        return redirect()
            ->route('admin.appointments.index')
            ->with('success', 'Đã từ chối lịch');
    }

    // Hoàn thành lịch
    public function complete(Appointment $appointment)
    {
        $appointment->update([
            'status' => 'completed',
            'payment_status' => 'paid'
        ]);

        return redirect()
            ->route('admin.appointments.index')
            ->with('success', 'Đã hoàn thành lịch');
    }

    // Hủy lịch
    public function cancel(Appointment $appointment)
    {
        $appointment->update([
            'status' => 'cancelled'
        ]);

        return redirect()
            ->route('admin.appointments.index')
            ->with('success', 'Đã hủy lịch');
    }
}
