<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Exception;

class SettingsController extends Controller
{
    public function index()
    {
        return view('settings');
    }
}
