<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function showAdminDashboard()
    {



        return view('panel.admin.pages.adminmainpage');
    }
}
