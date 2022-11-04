<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role_id;

        if ($role == 'R3') return redirect('shopper/create');
        if ($role == 'R2') return redirect('market/analytics');
        if ($role == 'R1') return redirect('admin');
    }
}
