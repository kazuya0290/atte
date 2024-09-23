<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    public function index()
    {
        return view('login');
    }
    
    public function store(LoginRequest $request): RedirectResponse
    {
        if ($request->has('back')) {
            return redirect('/')->withInput();
        }
    }

    public function destroy(Request $request): RedirectResponse
    {

        Auth::guard('home')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login')->intended;
    }
}


