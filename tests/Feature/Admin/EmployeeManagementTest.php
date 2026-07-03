<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\User;
use App\Models\Service;
use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmployeeManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'role' => 'admin'
        ]);
    }

    public function test_admin_can_view_employee_list()
    {
        Employee::factory()->count(3)->create();

        $response = $this->actingAs($this->admin)
            ->get(route('admin.employees.index'));

        $response->assertStatus(200);

        $response->assertViewHas('employees');
    }

    public function test_admin_can_view_create_employee_page()
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.employees.create'));

        $response->assertStatus(200);
    }

    public function test_admin_can_create_employee()
    {
        $services = Service::factory()->count(2)->create();

        $response = $this->actingAs($this->admin)
            ->post(route('admin.employees.store'), [
                'name' => 'Nguyen Van A',
                'phone' => '0987654321',
                'email' => 'a@gmail.com',
                'service_ids' => $services->pluck('id')->toArray()
            ]);

        $response->assertRedirect(
            route('admin.employees.index')
        );

        $this->assertDatabaseHas('employees', [
            'name' => 'Nguyen Van A',
            'phone' => '0987654321',
            'email' => 'a@gmail.com'
        ]);

        $employee = Employee::first();

        $this->assertCount(
            2,
            $employee->services
        );
    }

    public function test_name_is_required()
    {
        $service = Service::factory()->create();

        $response = $this->actingAs($this->admin)
            ->post(route('admin.employees.store'), [
                'name' => '',
                'phone' => '0987654321',
                'service_ids' => [$service->id]
            ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_phone_is_required()
    {
        $service = Service::factory()->create();

        $response = $this->actingAs($this->admin)
            ->post(route('admin.employees.store'), [
                'name' => 'Nguyen Van A',
                'phone' => '',
                'service_ids' => [$service->id]
            ]);

        $response->assertSessionHasErrors('phone');
    }

    public function test_phone_must_be_numeric()
    {
        $service = Service::factory()->create();

        $response = $this->actingAs($this->admin)
            ->post(route('admin.employees.store'), [
                'name' => 'Nguyen Van A',
                'phone' => 'abc123',
                'service_ids' => [$service->id]
            ]);

        $response->assertSessionHasErrors('phone');
    }

    public function test_phone_cannot_exceed_ten_digits()
    {
        $service = Service::factory()->create();

        $response = $this->actingAs($this->admin)
            ->post(route('admin.employees.store'), [
                'name' => 'Nguyen Van A',
                'phone' => '012345678901',
                'service_ids' => [$service->id]
            ]);

        $response->assertSessionHasErrors('phone');
    }

    public function test_email_must_be_unique()
    {
        Employee::factory()->create([
            'email' => 'test@gmail.com'
        ]);

        $service = Service::factory()->create();

        $response = $this->actingAs($this->admin)
            ->post(route('admin.employees.store'), [
                'name' => 'Nguyen Van A',
                'phone' => '0987654321',
                'email' => 'test@gmail.com',
                'service_ids' => [$service->id]
            ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_service_is_required()
    {
        $response = $this->actingAs($this->admin)
            ->post(route('admin.employees.store'), [
                'name' => 'Nguyen Van A',
                'phone' => '0987654321'
            ]);

        $response->assertSessionHasErrors('service_ids');
    }

    public function test_admin_can_view_edit_page()
    {
        $employee = Employee::factory()->create();

        $response = $this->actingAs($this->admin)
            ->get(route('admin.employees.edit', $employee));

        $response->assertStatus(200);
    }

    public function test_admin_can_update_employee()
    {
        $employee = Employee::factory()->create();

        $services = Service::factory()->count(2)->create();

        $response = $this->actingAs($this->admin)
            ->put(
                route('admin.employees.update', $employee),
                [
                    'name' => 'Updated Employee',
                    'phone' => '0999999999',
                    'email' => 'updated@gmail.com',
                    'service_ids' => $services->pluck('id')->toArray()
                ]
            );

        $response->assertRedirect(
            route('admin.employees.index')
        );

        $this->assertDatabaseHas('employees', [
            'id' => $employee->id,
            'name' => 'Updated Employee',
            'phone' => '0999999999'
        ]);

        $employee->refresh();

        $this->assertCount(
            2,
            $employee->services
        );
    }

    public function test_update_keeps_same_email()
    {
        $employee = Employee::factory()->create([
            'email' => 'same@gmail.com'
        ]);

        $service = Service::factory()->create();

        $response = $this->actingAs($this->admin)
            ->put(
                route('admin.employees.update', $employee),
                [
                    'name' => 'Updated',
                    'phone' => '0987654321',
                    'email' => 'same@gmail.com',
                    'service_ids' => [$service->id]
                ]
            );

        $response->assertSessionHasNoErrors();
    }

    public function test_services_are_synced_when_updating()
    {
        $employee = Employee::factory()->create();

        $oldService = Service::factory()->create();

        $employee->services()->attach(
            $oldService->id
        );

        $newServices = Service::factory()
            ->count(2)
            ->create();

        $this->actingAs($this->admin)
            ->put(
                route('admin.employees.update', $employee),
                [
                    'name' => $employee->name,
                    'phone' => $employee->phone,
                    'email' => $employee->email,
                    'service_ids' => $newServices
                        ->pluck('id')
                        ->toArray()
                ]
            );

        $employee->refresh();

        $this->assertCount(
            2,
            $employee->services
        );

        $this->assertFalse(
            $employee->services
                ->contains($oldService)
        );
    }

    public function test_admin_can_delete_employee()
    {
        $employee = Employee::factory()->create();

        $service = Service::factory()->create();

        $employee->services()->attach(
            $service->id
        );

        $response = $this->actingAs($this->admin)
            ->delete(
                route(
                    'admin.employees.destroy',
                    $employee
                )
            );

        $response->assertRedirect(
            route('admin.employees.index')
        );

        $this->assertDatabaseMissing(
            'employees',
            ['id' => $employee->id]
        );
    }

    public function test_services_are_detached_when_employee_deleted()
    {
        $employee = Employee::factory()->create();

        $service = Service::factory()->create();

        $employee->services()->attach($service->id);

        $this->actingAs($this->admin)
            ->delete(
                route(
                    'admin.employees.destroy',
                    $employee
                )
            );

        $this->assertDatabaseMissing(
            'employee_services',
            [
                'employee_id' => $employee->id,
                'service_id' => $service->id
            ]
        );
    }

    public function test_normal_user_cannot_access_employee_management()
    {
        $user = User::factory()->create([
            'role' => 'user'
        ]);

        $response = $this->actingAs($user)
            ->get(route('admin.employees.index'));

        $response->assertRedirect('/home');
    }
}