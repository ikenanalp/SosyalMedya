<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //Kullanıcı adı gönderme
    public function showAdminDashboard()
    {
        $user = Auth::user();


        return view('panel.admin.pages.adminmainpage',compact('user'));
    }

    //


}
