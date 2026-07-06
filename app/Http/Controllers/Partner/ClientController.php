<?php

declare(strict_types=1);

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\PartnerAssignment;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function index()
    {
        $partnerId = Auth::id();
        $assignments = PartnerAssignment::with('sponsor')
            ->where('partner_id', $partnerId)
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('partner.clients.index', compact('assignments'));
    }

    public function show(int $id)
    {
        $partnerId = Auth::id();
        $assignment = PartnerAssignment::with('sponsor')
            ->where('partner_id', $partnerId)
            ->findOrFail($id);

        return view('partner.clients.show', compact('assignment'));
    }
}
