<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PartnerCommission;
use Illuminate\Http\Request;

class AdminPartnerCommissionController extends Controller
{
    public function index(Request $request)
    {
        $query = PartnerCommission::with(['partner', 'deal']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->whereHas('partner', function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%");
            });
        }

        $commissions = $query->latest()->paginate(20);

        $totals = [
            'pending' => PartnerCommission::where('status', 'pending')->sum('amount'),
            'approved' => PartnerCommission::where('status', 'approved')->sum('amount'),
            'paid' => PartnerCommission::where('status', 'paid')->sum('amount'),
        ];

        return view('admin.partner-commissions.index', compact('commissions', 'totals'));
    }
}
