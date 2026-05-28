<?php

namespace Tests\Feature\Auth;

<<<<<<< HEAD
=======
use App\Providers\RouteServiceProvider;
>>>>>>> 65b90b2f919fd62cef96302c70bf2e394d257722
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertAuthenticated();
<<<<<<< HEAD
        $response->assertRedirect(route('dashboard', absolute: false));
=======
        $response->assertRedirect(RouteServiceProvider::HOME);
>>>>>>> 65b90b2f919fd62cef96302c70bf2e394d257722
    }
}
