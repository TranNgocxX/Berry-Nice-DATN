<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Appointment;
use App\Services\BookingService;
use App\Services\SlotService;
use App\Http\Requests\GetSlotsRequest;
use App\Http\Requests\StoreAppointmentRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AppointmentController extends Controller
{
    protected $bookingService;
    protected $slotService;

    public function __construct(
        BookingService $bookingService,
        SlotService $slotService
    ) {
        $this->bookingService = $bookingService;
        $this->slotService = $slotService;
    }

    public function index(Request $request)
    {
        $query = Appointment::where('user_id', Auth::id())
            ->with(['service', 'employee']);

        // Lọc theo từ khóa (tên dịch vụ)
        if ($request->filled('keyword')) {
            $query->whereHas('service', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->keyword . '%');
            });
        }

        // Lọc theo trạng thái
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Lọc theo ngày
        if ($request->filled('date')) {
            $query->whereDate('start_time', $request->date);
        }

        $appointments = $query->latest()->paginate(10)->withQueryString();

        return view('user.appointments.index', compact('appointments'));
    }

    public function create(Request $request)
    {
        $service = Service::findOrFail($request->service_id);

        return view('user.appointments.create', compact('service'));
    }

    public function getSlots(GetSlotsRequest $request)
    {
        $slots = $this->slotService->getAvailableSlots(
            $request->service_id,
            $request->date
        );
        return response()->json($slots);
    }

    public function store(StoreAppointmentRequest $request)
    {
        try {
            $appointment = $this->bookingService->createAppointment($request->validated(), Auth::id());
            return redirect()->route('appointments.success', ['id' => $appointment->id]);
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        $appointment = Appointment::where('user_id', Auth::id())
            ->with(['service', 'detail'])
            ->findOrFail($id);

        return view('user.appointments.show', compact('appointment'));
    }

    public function success($id)
    {
        $appointment = Appointment::where('user_id', Auth::id())
            ->with(['service'])
            ->findOrFail($id);

        return view('user.appointments.success', compact('appointment'));
    }
}
