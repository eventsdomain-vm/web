<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PartnerAssignment;
use Illuminate\Http\Request;

class AdminPartnerClientController extends Controller
{
    public function index(Request $request)
    {
        $query = PartnerAssignment::with(['partner', 'sponsor']);

        if ($request->filled('search')) {
            $query->whereHas('partner', function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%");
            });
        }

        $assignments = $query->latest()->paginate(20);

        return view('admin.partner-clients.index', compact('assignments'));
    }

    public function show(PartnerAssignment $assignment)
    {
        $assignment->load(['partner', 'sponsor', 'event']);

        return view('admin.partner-clients.show', compact('assignment'));
    }
}
