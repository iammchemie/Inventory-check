<?php

namespace App\Http\Controllers;

use App\Models\Reagensia;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        return view('dashboard.dashboard', [
            'title' => 'Dashboard',
            'user' => $request,
            'reagensia' => Reagensia::paginate(5),
            'reagensiastok' => Reagensia::all(),
            'users' => User::count(),
            'user' => User::all()
        ]);
    }
}
