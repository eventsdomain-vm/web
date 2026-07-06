<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PartnerService;
use Illuminate\Http\Request;

class AdminPartnerServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = PartnerService::with(['partner', 'category']);

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                    ->orWhereHas('partner', fn ($pq) => $pq->where('name', 'like', "%{$request->search}%"));
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('pricing_model')) {
            $query->where('pricing_model', $request->pricing_model);
        }

        $services = $query->latest()->paginate(20);

        return view('admin.partner-services.index', compact('services'));
    }

    public function show(PartnerService $service)
    {
        $service->load(['partner', 'category', 'reviews.organizer']);

        return view('admin.partner-services.show', compact('service'));
    }

    public function toggle(PartnerService $service)
    {
        $service->update(['is_available' => ! $service->is_available]);

        return back()->with('success', 'Service availability toggled.');
    }

    public function destroy(PartnerService $service)
    {
        $service->delete();

        return redirect()->route('admin.partner-services.index')
            ->with('success', 'Service deleted.');
    }
}
