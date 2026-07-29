<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function showMySettingPage(){

        return view('panel.userpages.settingpage');
    }


}
