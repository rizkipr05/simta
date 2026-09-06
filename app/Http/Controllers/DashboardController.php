<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        return match ($user->role) {
            User::ROLE_SUPER_ADMIN,
            User::ROLE_PENGELOLA => redirect()->route('admin.dashboard'),
            User::ROLE_DEKAN => redirect()->route('dekan.dashboard'),
            User::ROLE_KAPRODI => redirect()->route('kaprodi.dashboard'),
            User::ROLE_DOSEN => redirect()->route('dosen.dashboard'),
            User::ROLE_MAHASISWA => redirect()->route('mahasiswa.dashboard'),
            default => redirect()->route('login'),
        };
    }
}
