<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;

class AdminPartnerController extends Controller
{
    use LogsActivity;

    public function index(Request $request)
    {
        $query = User::role('partner')->with('profile');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                    ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        $partners = $query->latest()->paginate(20);

        return view('admin.partners', compact('partners'));
    }

    public function verify(User $partner)
    {
        $partner->update(['is_verified' => true]);

        $this->logActivity(
            'partner_verified',
            "Partner '{$partner->name}' verified",
            $partner,
            ['previous_status' => 'unverified', 'new_status' => 'verified']
        );

        return redirect()->route('admin.partners')
            ->with('success', 'Partner verified successfully!');
    }
}
