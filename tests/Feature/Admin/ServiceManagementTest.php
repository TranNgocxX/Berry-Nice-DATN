<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\User;
use App\Models\Service;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ServiceManagementTest extends TestCase
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

    // xem danh sách DV
    public function test_admin_can_view_service_list()
    {
        Service::factory()->count(3)->create();

        $response = $this->actingAs($this->admin)
            ->get(route('admin.services.index'));

        $response->assertStatus(200);

        $response->assertViewHas('services');
    }

    // xem trang tạo DV
    public function test_admin_can_view_create_service_page()
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.services.create'));

        $response->assertStatus(200);
    }

    // tạo DV mới
    public function test_admin_can_create_service()
    {
        $category = Category::factory()->create();

        $data = [
            'name' => 'Massage VIP',
            'category_id' => $category->id,
            'short_description' => 'Mô tả ngắn',
            'long_description' => 'Mô tả dài',
            'duration' => 60,
            'max_slot' => 5,
            'price' => 500000
        ];

        $response = $this->actingAs($this->admin)
            ->post(route('admin.services.store'), $data);

        $response->assertRedirect(
            route('admin.services.index')
        );

        $this->assertDatabaseHas('services', [
            'name' => 'Massage VIP',
            'category_id' => $category->id
        ]);
    }

    // tạo DV với ảnh
    public function test_admin_can_create_service_with_image()
    {
        Storage::fake('public');

        $category = Category::factory()->create();

        $file = UploadedFile::fake()->image('service.jpg');

        $response = $this->actingAs($this->admin)
            ->post(route('admin.services.store'), [
                'name' => 'Massage VIP',
                'category_id' => $category->id,
                'short_description' => 'Test',
                'long_description' => 'Test',
                'duration' => 60,
                'max_slot' => 5,
                'price' => 500000,
                'image' => $file
            ]);

        $response->assertRedirect(route('admin.services.index'));

        $service = Service::first();

        $this->assertTrue(Storage::disk('public')->exists($service->image));
    }

    // ktra tên DV là bắt buộc
    public function test_service_name_is_required()
    {
        $category = Category::factory()->create();

        $response = $this->actingAs($this->admin)
            ->post(route('admin.services.store'), [
                'name' => '',
                'category_id' => $category->id,
                'duration' => 60,
                'max_slot' => 5,
                'price' => 500000
            ]);

        $response->assertSessionHasErrors('name');
    }

    // ktra danh mục là bắt buộc
    public function test_category_is_required()
    {
        $response = $this->actingAs($this->admin)
            ->post(route('admin.services.store'), [
                'name' => 'Massage',
                'duration' => 60,
                'max_slot' => 5,
                'price' => 500000
            ]);

        $response->assertSessionHasErrors('category_id');
    }

    // ktra thời lượng phải lớn hơn 0
    public function test_duration_must_be_greater_than_zero()
    {
        $category = Category::factory()->create();

        $response = $this->actingAs($this->admin)
            ->post(route('admin.services.store'), [
                'name' => 'Massage',
                'category_id' => $category->id,
                'duration' => 0,
                'max_slot' => 5,
                'price' => 500000
            ]);

        $response->assertSessionHasErrors('duration');
    }

    // ktra slot phải lớn hơn 0
    public function test_max_slot_must_be_greater_than_zero()
    {
        $category = Category::factory()->create();

        $response = $this->actingAs($this->admin)
            ->post(route('admin.services.store'), [
                'name' => 'Massage',
                'category_id' => $category->id,
                'duration' => 60,
                'max_slot' => 0,
                'price' => 500000
            ]);

        $response->assertSessionHasErrors('max_slot');
    }

    // ktra giá không thể âm
    public function test_price_cannot_be_negative()
    {
        $category = Category::factory()->create();

        $response = $this->actingAs($this->admin)
            ->post(route('admin.services.store'), [
                'name' => 'Massage',
                'category_id' => $category->id,
                'duration' => 60,
                'max_slot' => 5,
                'price' => -1
            ]);

        $response->assertSessionHasErrors('price');
    }

    // xem chi tiết DV
    public function test_admin_can_view_service_detail()
    {
        $service = Service::factory()->create();

        $response = $this->actingAs($this->admin)
            ->get(route('admin.services.show', $service));

        $response->assertStatus(200);

        $response->assertViewHas('service');
    }

    // xem trang sửa DV
    public function test_admin_can_view_edit_page()
    {
        $service = Service::factory()->create();

        $response = $this->actingAs($this->admin)
            ->get(route('admin.services.edit', $service));

        $response->assertStatus(200);
    }

    // cập nhật DV
    public function test_admin_can_update_service()
    {
        $service = Service::factory()->create();

        $category = Category::factory()->create();

        $response = $this->actingAs($this->admin)
            ->put(route('admin.services.update', $service),
                [
                    'name' => 'Massage Luxury',
                    'category_id' => $category->id,
                    'short_description' => 'Updated',
                    'long_description' => 'Updated',
                    'duration' => 90,
                    'max_slot' => 10,
                    'price' => 800000
                ]
            );

        $response->assertRedirect(
            route('admin.services.index')
        );

        $this->assertDatabaseHas('services', [
            'id' => $service->id,
            'name' => 'Massage Luxury',
            'duration' => 90
        ]);
    }

    // validation lhi update
    public function test_update_requires_name()
    {
        $service = Service::factory()->create();

        $response = $this->actingAs($this->admin)
            ->put(route('admin.services.update', $service),
                [
                    'name' => ''
                ]
            );

        $response->assertSessionHasErrors('name');
    }

    // xoá DV
    public function test_admin_can_delete_service()
    {
        $service = Service::factory()->create();

        $response = $this->actingAs($this->admin)
            ->delete(route('admin.services.destroy', $service));

        $response->assertRedirect(route('admin.services.index'));

        $this->assertDatabaseMissing('services', [
            'id' => $service->id
        ]);
    }

    // xoá ảnh cũ khi update 
    public function test_old_image_is_deleted_when_updating()
    {
        Storage::fake('public');

        $category = Category::factory()->create();

        $oldFile = UploadedFile::fake()
            ->image('old.jpg');

        $service = Service::factory()->create([
            'category_id' => $category->id,
            'image' => $oldFile->store(
                'services',
                'public'
            )
        ]);

        $oldPath = $service->image;

        $newFile = UploadedFile::fake()
            ->image('new.jpg');

        $this->actingAs($this->admin)
            ->put(
                route('admin.services.update', $service),
                [
                    'name' => 'Updated Service',
                    'category_id' => $category->id,
                    'short_description' => 'Updated',
                    'long_description' => 'Updated',
                    'duration' => 60,
                    'max_slot' => 5,
                    'price' => 500000,
                    'image' => $newFile
                ]
            );

        $this->assertFalse(Storage::disk('public')->exists($oldPath));

        $this->assertTrue(Storage::disk('public')->exists($service->fresh()->image));
    }

    public function test_normal_user_cannot_access_service_management()
    {
        $user = User::factory()->create([
            'role' => 'user'
        ]);

        $response = $this->actingAs($user)
            ->get(route('admin.services.index'));

        $response->assertRedirect('/home');
    }
}
