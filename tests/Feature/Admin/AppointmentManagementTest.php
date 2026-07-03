<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\User;
use App\Models\Appointment;
use App\Models\Service;
use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AppointmentManagementTest extends TestCase
{
    use RefreshDatabase;

    private function admin()
    {
        return User::factory()->create([
            'role' => 'admin'
        ]);
    }

    public function test_admin_can_view_appointments_list()
    {
        $admin = $this->admin();

        $response = $this->actingAs($admin)
            ->get(route('admin.appointments.index'));

        $response->assertStatus(200);
    }

    public function test_admin_can_view_appointment_detail_page()
    {
        $admin = $this->admin();

        // $appointment = Appointment::factory()->create();
        $appointment = Appointment::factory()->withDetail()->create();

        $response = $this->actingAs($admin)
            ->get(route('admin.appointments.show', $appointment->id));

        $response->assertStatus(200);
    }

    public function test_admin_can_confirm_appointment_with_employee()
    {
        $admin = $this->admin();

        $service = Service::factory()->create([
            'duration' => 60,
            'max_slot' => 2,
        ]);

        $employee = Employee::factory()->create();

        $employee->services()->attach($service->id);

        $appointment = Appointment::factory()->withDetail()->create([
            'service_id' => $service->id,
            'employee_id' => null,
            'status' => 'pending',
            'start_time' => now()->addDay()->setHour(10),
            'end_time' => now()->addDay()->setHour(11),
        ]);

        $response = $this->actingAs($admin)
            ->post(route('admin.appointments.confirm', $appointment->id), [
                'employee_id' => $employee->id
            ]);

        $response->assertRedirect(route('admin.appointments.index'));

        $this->assertDatabaseHas('appointments', [
            'id' => $appointment->id,
            'employee_id' => $employee->id,
            'status' => 'confirmed',
        ]);
    }

    public function test_admin_can_reject_appointment()
    {
        $admin = $this->admin();

        $appointment = Appointment::factory()->withDetail()->create([
            'status' => 'pending'
        ]);

        $response = $this->actingAs($admin)
            ->post(route('admin.appointments.reject', $appointment->id));

        $response->assertRedirect(route('admin.appointments.index'));

        $this->assertDatabaseHas('appointments', [
            'id' => $appointment->id,
            'status' => 'rejected',
        ]);
    }

    public function test_admin_can_complete_appointment()
    {
        $admin = $this->admin();

        $appointment = Appointment::factory()->withDetail()->create([
            'status' => 'confirmed',
            'payment_status' => 'unpaid'
        ]);

        $response = $this->actingAs($admin)
            ->post(route('admin.appointments.complete', $appointment->id));

        $response->assertRedirect(route('admin.appointments.index'));

        $this->assertDatabaseHas('appointments', [
            'id' => $appointment->id,
            'status' => 'completed',
            'payment_status' => 'paid',
        ]);
    }

    public function test_admin_can_cancel_appointment()
    {
        $admin = $this->admin();

        $appointment = Appointment::factory()->withDetail()->create([
            'status' => 'pending'
        ]);

        $response = $this->actingAs($admin)
            ->post(route('admin.appointments.cancel', $appointment->id));

        $response->assertRedirect(route('admin.appointments.index'));

        $this->assertDatabaseHas('appointments', [
            'id' => $appointment->id,
            'status' => 'cancelled',
        ]);
    }

    public function test_confirm_requires_employee_id()
    {
        $admin = $this->admin();
        $appointment = Appointment::factory()->withDetail()->create();

        $response = $this->actingAs($admin)
            ->post(route('admin.appointments.confirm', $appointment->id), []);

        $response->assertSessionHasErrors('employee_id');
    }
}