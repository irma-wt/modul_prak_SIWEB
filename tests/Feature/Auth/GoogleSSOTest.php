<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;
use Tests\TestCase;

class GoogleSSOTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that the google redirect route redirects to google oauth url.
     */
    public function test_google_sso_redirects_to_google(): void
    {
        $response = $this->get('/auth/google');

        $response->assertStatus(302);
        $this->assertStringContainsString('accounts.google.com', $response->getTargetUrl());
    }

    /**
     * Test that google callback registers and logs in a new user.
     */
    public function test_google_callback_registers_and_authenticates_new_user(): void
    {
        $googleUser = $this->createMock(SocialiteUser::class);
        $googleUser->method('getId')->willReturn('google-sso-id-123');
        $googleUser->method('getName')->willReturn('John Doe');
        $googleUser->method('getEmail')->willReturn('johndoe@example.com');

        $provider = $this->createMock(\Laravel\Socialite\Two\GoogleProvider::class);
        $provider->method('user')->willReturn($googleUser);

        Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

        $response = $this->get('/auth/google/callback');

        $response->assertRedirect(route('home', absolute: false));
        $this->assertAuthenticated();

        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'johndoe@example.com',
            'google_id' => 'google-sso-id-123',
        ]);
    }

    /**
     * Test that google callback logs in an existing user and updates their google_id if needed.
     */
    public function test_google_callback_logs_in_existing_user(): void
    {
        $user = User::factory()->create([
            'email' => 'existing@example.com',
            'google_id' => null,
        ]);

        $googleUser = $this->createMock(SocialiteUser::class);
        $googleUser->method('getId')->willReturn('google-sso-id-999');
        $googleUser->method('getName')->willReturn('Existing User');
        $googleUser->method('getEmail')->willReturn('existing@example.com');

        $provider = $this->createMock(\Laravel\Socialite\Two\GoogleProvider::class);
        $provider->method('user')->willReturn($googleUser);

        Socialite::shouldReceive('driver')->with('google')->andReturn($provider);

        $response = $this->get('/auth/google/callback');

        $response->assertRedirect(route('home', absolute: false));
        $this->assertAuthenticatedAs($user);

        $this->assertDatabaseHas('users', [
            'email' => 'existing@example.com',
            'google_id' => 'google-sso-id-999',
        ]);
    }
}
