<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Service;
use App\Models\Appointment;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()
            ->admin()
            ->create();
    }

    public function test_admin_can_view_category_list()
    {
        Category::factory()->count(3)->create();

        $response = $this->actingAs($this->admin)
            ->get(route('admin.categories.index'));

        $response->assertStatus(200);

        $response->assertViewHas('categories');
    }

    public function test_admin_can_create_category()
    {
        $data = [
            'name' => 'Spa Cao Cấp',
            'description' => 'Mô tả spa'
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.categories.store'), $data);

        $response->assertRedirect(
            route('admin.categories.index')
        );

        $this->assertDatabaseHas('categories', [
            'name' => 'Spa Cao Cấp'
        ]);
    }

    public function test_category_name_is_required_when_creating()
    {
        $response = $this->actingAs($this->admin)
            ->post(route('admin.categories.store'), [
                'name' => '',
            ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_category_name_must_be_unique()
    {
        Category::factory()->create([
            'name' => 'Massage'
        ]);

        $response = $this->actingAs($this->admin)
            ->post(route('admin.categories.store'), [
                'name' => 'Massage'
            ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_admin_can_update_category()
    {
        $category = Category::factory()->create();

        $response = $this->actingAs($this->admin)
            ->put(
                route(
                    'admin.categories.update',
                    $category
                ),
                [
                    'name' => 'Massage VIP',
                    'description' => 'Updated'
                ]
            );

        $response->assertRedirect(
            route('admin.categories.index')
        );

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'Massage VIP'
        ]);
    }

    public function test_update_requires_name()
    {
        $category = Category::factory()->create();

        $response = $this->actingAs($this->admin)
            ->put(
                route(
                    'admin.categories.update',
                    $category
                ),
                [
                    'name' => ''
                ]
            );

        $response->assertSessionHasErrors('name');
    }

    public function test_admin_can_delete_category()
    {
        $category = Category::factory()->create();

        $response = $this->actingAs($this->admin)
            ->delete(
                route(
                    'admin.categories.destroy',
                    $category
                )
            );

        $response->assertRedirect();

        $this->assertDatabaseMissing(
            'categories',
            [
                'id' => $category->id
            ]
        );
    }

    public function test_category_cannot_be_deleted_when_it_has_services()
    {
        $category = Category::factory()->create();

        Service::factory()->create([
            'category_id' => $category->id
        ]);

        $response = $this->actingAs($this->admin)
            ->delete(
                route(
                    'admin.categories.destroy',
                    $category
                )
            );

        $this->assertDatabaseHas('categories', [
            'id' => $category->id
        ]);
    }

    public function test_normal_user_cannot_access_category_management()
    {
        $user = User::factory()->create([
            'role' => 'user'
        ]);

        $response = $this->actingAs($user)
            ->get(route('admin.categories.index'));

        $response->assertRedirect('/home');
    }
}
