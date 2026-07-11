<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    use LogsActivity;

    public function index(Request $request)
    {
        $query = User::with('roles');

        if ($request->filled('role')) {
            $query->role($request->role);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                    ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        $users = $query->latest()->paginate(20);

        return view('admin.users', compact('users'));
    }

    public function show(User $user)
    {
        $user->load('profile', 'roles');

        return view('admin.users-show', compact('user'));
    }

    public function verify(User $user)
    {
        $user->update(['is_verified' => true]);

        $this->logActivity(
            'user_verified',
            "User '{$user->name}' verified",
            $user,
            ['previous_status' => 'unverified', 'new_status' => 'verified']
        );

        return redirect()->route('admin.users.show', $user)
            ->with('success', 'User verified successfully!');
    }

    public function ban(User $user)
    {
        $user->update(['is_verified' => false]);

        $this->logActivity(
            'user_banned',
            "User '{$user->name}' banned",
            $user,
            ['previous_status' => 'verified', 'new_status' => 'banned']
        );

        return redirect()->route('admin.users.show', $user)
            ->with('success', 'User has been banned.');
    }
}
