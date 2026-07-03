<?php

namespace Tests\Feature\User;

use App\Models\User;
use App\Models\Service;
use App\Models\Appointment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Carbon\Carbon;

class BookingTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_booking_form()
    {
        $user = User::factory()->create();
        $service = Service::factory()->create();

        $response = $this->actingAs($user)
            ->get(route('appointment.create', ['service_id' => $service->id]));

        $response->assertStatus(200);
    }

    public function test_user_can_create_appointment_successfully()
    {
        $user = User::factory()->create();

        $service = Service::factory()->create([
            'duration' => 60,
            'max_slot' => 2,
            'price' => 100000,
        ]);

        $response = $this->actingAs($user)
            ->post(route('appointment.store'), [
                'service_id' => $service->id,
                'start_time' => Carbon::now()->addHour()->format('Y-m-d H:i:s'),
                'customer_name' => 'John Doe',
                'phone' => '0912345678',
                'email' => 'john@test.com',
                'payment_method' => 'cash',
            ]);

        $appointment = Appointment::first();

        $response->assertRedirect(route('appointments.success', ['id' => $appointment->id]));

        $this->assertDatabaseHas('appointments', [
            'user_id' => $user->id,
            'service_id' => $service->id,
            'status' => 'pending',
        ]);

        $this->assertDatabaseHas('appointment_details', [
            'appointment_id' => $appointment->id,
            'customer_name' => 'John Doe',
        ]);
    }

    public function test_cannot_book_if_slot_is_full()
    {
        $user = User::factory()->create();

        $service = Service::factory()->create([
            'max_slot' => 1,
            'duration' => 60,
        ]);

        $time = Carbon::now()->addHour();

        Appointment::factory()->create([
            'service_id' => $service->id,
            'start_time' => $time,
            'status' => 'confirmed',
        ]);

        $response = $this->actingAs($user)
            ->post(route('appointment.store'), [
                'service_id' => $service->id,
                'start_time' => $time->format('Y-m-d H:i:s'),
                'customer_name' => 'Test User',
                'phone' => '0912345678',
                'payment_method' => 'cash',
            ]);

        $response->assertSessionHas('error');
    }

    public function test_store_requires_validation()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('appointment.store'), []);

        $response->assertSessionHasErrors([
            'service_id',
            'start_time',
            'customer_name',
            'phone',
            'payment_method'
        ]);
    }

    public function test_user_can_view_their_appointments() // Xem lịch hẹn của chính mình
    {
        $user = User::factory()->create();

        Appointment::factory()->count(3)->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)
            ->get(route('appointments.index'));

        $response->assertStatus(200);
    }

    public function test_user_can_view_appointment_detail()
    {
        $user = User::factory()->create();

        $appointment = Appointment::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)
            ->get(route('appointments.show', $appointment->id));

        $response->assertStatus(200);
    }

public function test_user_can_get_available_slots()
{
    $this->withoutExceptionHandling(); // Dòng này sẽ in ra Log lỗi thật thay vì trả về 404 chung chung

    $user = User::factory()->create();
    $service = Service::factory()->create();

    $response = $this->actingAs($user)
        ->getJson(route('appointments.getSlots', [
            'service_id' => $service->id,
            'date' => now()->addDay()->format('Y-m-d'),
        ]));

    $response->assertStatus(200);
    $response->assertJsonStructure([
        '*' => ['time', 'is_past', 'available', 'datetime']
    ]);
}

}
