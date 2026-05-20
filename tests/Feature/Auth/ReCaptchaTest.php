<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ReCaptchaTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_fails_without_recaptcha(): void
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionHasErrors(['g-recaptcha-response']);
        $this->assertGuest();
    }

    public function test_registration_succeeds_with_valid_recaptcha(): void
    {
        Http::fake([
            'https://www.google.com/recaptcha/api/siteverify' => Http::response(['success' => true], 200),
        ]);

        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'g-recaptcha-response' => 'valid-mock-token',
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertAuthenticated();
        $response->assertRedirect(route('home', absolute: false));
    }
}
