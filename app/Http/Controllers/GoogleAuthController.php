<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Exception;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            $user = User::where('google_id', $googleUser->getId())
                        ->orWhere('email', $googleUser->getEmail())
                        ->first();

            if ($user) {
                $user->update(['google_id' => $googleUser->getId()]);
                Auth::login($user);
            } else {
                $newUser = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password' => bcrypt(uniqid()), 
                    'role' => 'user'
                ]);
                Auth::login($newUser);
            }

            return redirect('/'); 
            
        } catch (Exception $e) {
            return redirect('/login')->with('error', 'Đăng nhập Google thất bại! Vui lòng thử lại.');
        }
    }
}