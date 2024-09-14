<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }
}
