<?php

namespace Tests\Feature\Auth;

use App\Models\User;
<<<<<<< HEAD
=======
use App\Providers\RouteServiceProvider;
>>>>>>> 65b90b2f919fd62cef96302c70bf2e394d257722
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_email_verification_screen_can_be_rendered(): void
    {
<<<<<<< HEAD
        $user = User::factory()->unverified()->create();
=======
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);
>>>>>>> 65b90b2f919fd62cef96302c70bf2e394d257722

        $response = $this->actingAs($user)->get('/verify-email');

        $response->assertStatus(200);
    }

    public function test_email_can_be_verified(): void
    {
<<<<<<< HEAD
        $user = User::factory()->unverified()->create();
=======
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);
>>>>>>> 65b90b2f919fd62cef96302c70bf2e394d257722

        Event::fake();

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1($user->email)]
        );

        $response = $this->actingAs($user)->get($verificationUrl);

        Event::assertDispatched(Verified::class);
        $this->assertTrue($user->fresh()->hasVerifiedEmail());
<<<<<<< HEAD
        $response->assertRedirect(route('dashboard', absolute: false).'?verified=1');
=======
        $response->assertRedirect(RouteServiceProvider::HOME.'?verified=1');
>>>>>>> 65b90b2f919fd62cef96302c70bf2e394d257722
    }

    public function test_email_is_not_verified_with_invalid_hash(): void
    {
<<<<<<< HEAD
        $user = User::factory()->unverified()->create();
=======
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);
>>>>>>> 65b90b2f919fd62cef96302c70bf2e394d257722

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            ['id' => $user->id, 'hash' => sha1('wrong-email')]
        );

        $this->actingAs($user)->get($verificationUrl);

        $this->assertFalse($user->fresh()->hasVerifiedEmail());
    }
}
