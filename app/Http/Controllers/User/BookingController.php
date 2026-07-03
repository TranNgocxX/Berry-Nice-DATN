<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Appointment;
use App\Services\BookingService;
use App\Services\SlotService;
use App\Http\Requests\GetSlotsRequest;
use App\Http\Requests\User\StoreBookingRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BookingController extends Controller
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
        $bookings = Appointment::with(['user', 'service:id,name'])
            ->where('user_id', Auth::id())
            ->filter($request->all()) // scope filter trong model Appointment
            ->latest()
            ->paginate(9)
            ->withQueryString();

        return view('user.bookings.index', compact('bookings'));
    }

    public function create(Request $request)
    {
        $service = Service::findOrFail($request->service_id);

        return view('user.bookings.create', compact('service'));
    }

    public function getSlots(GetSlotsRequest $request)
    {
        $slots = $this->slotService->getAvailableSlots(
            $request->service_id,
            $request->date
        );
        return response()->json($slots);
    }

    public function store(StoreBookingRequest $request)
    {
        try {
            $booking = $this->bookingService->createBooking($request->validated(), Auth::id());
            return redirect()->route('bookings.success', ['id' => $booking->id]);
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        $booking = Appointment::where('user_id', Auth::id())
            ->with(['service', 'appointmentDetail'])
            ->findOrFail($id);

        return view('user.bookings.show', compact('booking'));
    }

    public function success($id)
    {
        $booking = Appointment::where('user_id', Auth::id())
            ->with(['service', 'appointmentDetail'])
            ->findOrFail($id);

        return view('user.bookings.success', compact('booking'));
    }
}
