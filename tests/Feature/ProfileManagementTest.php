<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfileManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_profile_page()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('profile.index'));

        $response->assertRedirect(route('user.profile.index'));
    }

    public function test_admin_can_view_profile_page()
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get(route('profile.index'));

        $response->assertRedirect(route('admin.profile.index'));
    }

    public function test_user_can_update_profile()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->put(route('profile.update'), [
            'name' => 'New Name',
            'email' => 'newemail@gmail.com',
            'phone' => '0912345678',
            'address' => 'Hà Nội'
        ]);

        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'New Name',
            'email' => 'newemail@gmail.com',
        ]);
    }

    public function test_user_can_upload_avatar()
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $file = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->actingAs($user)->put(route('profile.update'), [
            'name' => $user->name,
            'email' => $user->email,
            'avt' => $file,
        ]);

        $response->assertSessionHasNoErrors();
    $path = $user->fresh()->avt;

    // Dùng PHPUnit helper thay vì Storage::assertExists
    $this->assertTrue(Storage::disk('public')->exists($path));
        // Storage::disk('public')->assertExists($user->fresh()->avt);

    }

    public function test_old_avatar_is_deleted_when_updating()
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'avt' => UploadedFile::fake()->image('old.jpg')->store('avatars', 'public')
        ]);

        $old = $user->avt;

        $newFile = UploadedFile::fake()->image('new.jpg');

        $this->actingAs($user)->put(route('profile.update'), [
            'name' => $user->name,
            'email' => $user->email,
            'avt' => $newFile,
        ]);

        $this->assertFalse(Storage::disk('public')->exists($old));
        $this->assertTrue(Storage::disk('public')->exists($user->fresh()->avt));
    }

    public function test_email_must_be_unique()
    {
        $user1 = User::factory()->create(['email' => 'test@gmail.com']);
        $user2 = User::factory()->create();

        $response = $this->actingAs($user2)->put(route('profile.update'), [
            'name' => $user2->name,
            'email' => $user1->email,
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_user_can_change_password()
    {
        $user = User::factory()->create([
            'password' => Hash::make('oldpassword')
        ]);

        $response = $this->actingAs($user)->put(route('profile.password'), [
            'current_password' => 'oldpassword',
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',
        ]);

        $response->assertSessionHasNoErrors();

        $this->assertTrue(Hash::check('newpassword', $user->fresh()->password));
    }
}
