<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_setup_is_shown_when_there_are_no_users(): void
    {
        $response = $this->get('/login');

        $response->assertRedirect(route('setup.create'));
    }

    public function test_login_is_shown_when_users_exist(): void
    {
        User::factory()->create();

        $response = $this->get('/login');

        $response->assertOk();
        $response->assertSee('Iniciar sesión');
    }

    public function test_first_admin_can_be_created_via_setup(): void
    {
        $response = $this->post('/setup', [
            'name' => 'Admin Inicial',
            'email' => 'admin@cpet.test',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/officers');
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'email' => 'admin@cpet.test',
            'role' => 'Administrador',
        ]);
    }

    public function test_health_endpoint_is_ok(): void
    {
        $response = $this->get('/up');

        $response->assertOk();
    }
}
