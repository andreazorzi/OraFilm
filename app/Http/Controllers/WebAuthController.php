<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class WebAuthController extends Controller
{
    // Login
    public function login(Request $request){
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        // Custom attempt to verify if user login is succesfull
        if (Auth::attempt(['username' => $credentials["username"], 'password' => $credentials["password"]]) && config("auth.web_login")) {
            $request->session()->regenerate();

            return redirect()->route('backoffice.index');
        }

        // Else return error
        return back()->withErrors(['login-form' => __('auth.failed-login')])->onlyInput('username');
    }

    // Logout
    public function logout(){
        Session::flush();
        Auth::logout();

        return redirect()->route('backoffice.index');
    }
    
    public function reset_password(Request $request, PasswordReset $reset_link){
        return view("backoffice.reset-password", ["reset_link" => $reset_link]);
    }
}
