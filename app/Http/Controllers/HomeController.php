<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use App\Http\Middleware\LogMiddleware;


// use Illuminate\Routing\Controllers\HasMiddleware;

// class HomeController extends Controller implements HasMiddleware
class HomeController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(LogMiddleware::class);
    // }

    public function index()
    {
        return view('home');
    }

    // public static function middleware(): array
    // {

    //     return [
    //         'auth',
    //         // new Middleware('log', only: ['index']),
    //         // new Middleware('subscribed', except: ['store'])
    //     ];
    // }
}
