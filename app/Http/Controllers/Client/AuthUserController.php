<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthUserController extends Controller
{
    public function indexLogin()
    {
        return view(
            'admin/login/index',
            [
                'title' => 'Login',
                'active' => 'login',
            ]
        );
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $sessionToken = session()->getId();

            setcookie('tokenlogin', $sessionToken, time() + (86400 * 30), "/"); // Cookie will expire in 30 days

            return redirect()->intended('/dashboard');
        }
        return back()->withErrors(['title' => 'Sign In Failed', 'credentials' => 'Please check your email and password again!']);
        return view('admin/dashboard/index');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        setcookie('tokenlogin', '', time() - 3600, "/");

        return redirect('/login');
    }
}
