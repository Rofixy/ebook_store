<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleProviderCallback(Request $request)
    {
        try {
            // Ambil data pengguna dari Google
            $user_google = Socialite::driver('google')->user();
            $user = User::where('email', $user_google->getEmail())->first();

            if ($user) {
                // Login pengguna yang sudah ada
                \auth()->login($user, true);
                return redirect()->route('home');
            } else {
                // Buat pengguna baru jika belum ada
                $newUser = User::create([
                    'email'             => $user_google->getEmail(),
                    'name'              => $user_google->getName(),
                    'password'          => 0, // Default password
                    'email_verified_at' => now(),
                ]);

                \auth()->login($newUser, true);
                return redirect()->route('home');
            }
        } catch (\Exception $e) {
            Log::error('Error during Google login: ' . $e->getMessage());
            return redirect()->route('login')->with('error', 'Login gagal, coba lagi nanti.');
        }
    }
}
