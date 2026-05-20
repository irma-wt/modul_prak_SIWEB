<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirectToGoogle(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google and log them in.
     */
    public function handleGoogleCallback(): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Gagal masuk menggunakan Google.');
        }

        $user = User::where('email', $googleUser->getEmail())->first();

        if ($user) {
            // Jika email terdaftar, langsung izinkan masuk dan simpan google_id jika belum ada
            if (empty($user->google_id)) {
                $user->update(['google_id' => $googleUser->getId()]);
            }
        } else {
            // Jika email tidak terdaftar, buat akun baru
            $user = User::create([
                'name' => $googleUser->getName() ?? $googleUser->getNickname() ?? 'Google User',
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'password' => Hash::make(Str::random(24)),
            ]);
        }

        Auth::login($user);

        return redirect()->intended(route('home', absolute: false));
    }
}
