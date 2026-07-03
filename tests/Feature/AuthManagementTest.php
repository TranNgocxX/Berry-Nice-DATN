<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_login_page()
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
    }

    public function test_user_can_view_register_page()
    {
        $response = $this->get(route('register'));

        $response->assertStatus(200);
    }

    public function test_user_can_register_successfully()
    {
        $response = $this->post(route('register'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/login');

        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com',
            'name' => 'John Doe',
        ]);
    }

    public function test_register_requires_validation()
    {
        $response = $this->post(route('register'), []);

        $response->assertSessionHasErrors(['name', 'email', 'password']);
    }

    public function test_user_can_login_and_redirect_to_home()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
            'role' => 'user',
        ]);

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_admin_login_redirects_to_dashboard()
    {
        $admin = User::factory()->admin()->create([
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post(route('login'), [
            'email' => $admin->email,
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin);
    }

    public function test_login_fails_with_wrong_credentials()
    {
        $user = User::factory()->create();

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $response->assertSessionHas('error');
        $this->assertGuest();
    }

    public function test_user_can_logout()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->post(route('logout'));

        $response->assertRedirect('/login');
        $this->assertGuest();
    }
}