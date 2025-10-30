<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClientUser;

class SettingsController extends Controller
{

    public function index()
    {
        return view('settings.index');
    }
}
