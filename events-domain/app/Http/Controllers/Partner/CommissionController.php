<?php

declare(strict_types=1);

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\PartnerCommission;
use Illuminate\Support\Facades\Auth;

class CommissionController extends Controller
{
    public function index()
    {
        $commissions = PartnerCommission::with('deal')
            ->where('partner_id', Auth::id())
            ->orderByDesc('created_at')
            ->paginate(20);

        $totals = [
            'pending' => PartnerCommission::where('partner_id', Auth::id())->where('status', 'pending')->sum('amount'),
            'approved' => PartnerCommission::where('partner_id', Auth::id())->where('status', 'approved')->sum('amount'),
            'paid' => PartnerCommission::where('partner_id', Auth::id())->where('status', 'paid')->sum('amount'),
        ];

        return view('partner.commissions.index', compact('commissions', 'totals'));
    }
}
