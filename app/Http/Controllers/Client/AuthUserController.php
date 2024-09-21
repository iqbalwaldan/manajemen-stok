<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthUserController extends Controller
{
    public function indexLogin()
    {
        return view('admin/login/index');
    }

    public function login(Request $request){
        // dd($request->all());
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (Auth::attempt($credentials)) {
            // if (auth()->user()->email_verified_at == null) {
            //     Auth::logout();
            //     return back()->withErrors(['title' => 'Verify Email', 'credentials' => 'Please verify your email first!']);
            // }
            // Regenerate the session
            $request->session()->regenerate();

            // Generate a session token
            $sessionToken = session()->getId();

            // Save the session token in a cookie
            setcookie('tokenlogin', $sessionToken, time() + (86400 * 30), "/"); // Cookie will expire in 30 days

            return redirect()->intended('/dashboard');
        }
        // return back()->with('error', 'Login failed!');
        return back()->withErrors(['title' => 'Sign In Failed', 'credentials' => 'Please check your email and password again!']);
        return view('admin/dashboard/index');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        // Make invalidate the session
        $request->session()->invalidate();

        // Regenerate the session
        $request->session()->regenerateToken();

        // Delete the session token in a cookie 
        setcookie('tokenlogin', '', time() - 3600, "/");

        return redirect('/login');
    }

}
