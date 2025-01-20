<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/admin/dashboard'; // After login redirect to admin dashboard

    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout'); // Protect admin routes
    }

    /**
     * Show the admin login form.
     */
    public function showLoginForm()
    {
        return view('admin.auth.login'); // Return the login form view
    }

    /**
     * Guard for admin authentication.
     */
    protected function guard()
    {
        return auth()->guard('admin');
    }

    /**
     * Log the admin out and redirect to login page.
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
