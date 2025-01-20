<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin'); // Only authenticated admins can access
    }

    public function dashboard()
    {
        return view('admin.layouts.master'); // Admin dashboard view
    }
}
