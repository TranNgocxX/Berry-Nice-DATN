<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Appointment;
use App\Services\BookingService;
use App\Services\SlotService;
use App\Http\Requests\GetSlotsRequest;
use App\Http\Requests\User\StoreAppointmentRequest;
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
        $appointments = Appointment::with(['user', 'service:id,name'])
            ->where('user_id', Auth::id())
            ->filter($request->all()) // sd scope filter trong model Appointment
            ->latest()
            ->paginate(9)
            ->withQueryString();

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
            ->with(['service', 'appointmentDetail'])
            ->findOrFail($id);

        return view('user.appointments.show', compact('appointment'));
    }

    public function success($id)
    {
        $appointment = Appointment::where('user_id', Auth::id())
            ->with(['service', 'appointmentDetail'])
            ->findOrFail($id);

        return view('user.appointments.success', compact('appointment'));
    }
}
