<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;

class DashboardController extends Controller
{
    public function __invoke(): RedirectResponse
    {
        $user = auth()->user();

        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->hasRole('organizer')) {
            return redirect()->route('organizer.dashboard');
        }

        if ($user->hasRole('sponsor')) {
            return redirect()->route('sponsor.dashboard');
        }

        if ($user->hasRole('partner')) {
            return redirect()->route('partner.dashboard');
        }

        return redirect()->route('home');
    }
}
