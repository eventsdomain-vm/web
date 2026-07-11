<?php

declare(strict_types=1);

namespace App\Http\Controllers\Sponsor;

use App\Http\Controllers\Controller;
use App\Models\SponsorBudget;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BudgetController extends Controller
{
    public function index(): View
    {
        $budgets = auth()->user()->sponsorBudgets()
            ->latest('fiscal_year')
            ->get();

        $currentBudget = auth()->user()->sponsorBudgets()
            ->where('fiscal_year', date('Y'))
            ->first();

        return view('sponsor.budget.index', compact('budgets', 'currentBudget'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'fiscal_year' => 'required|integer|min:2024|max:2035',
            'total_budget' => 'required|numeric|min:0',
        ]);

        SponsorBudget::updateOrCreate(
            [
                'sponsor_id' => auth()->id(),
                'fiscal_year' => $validated['fiscal_year'],
            ],
            [
                'total_budget' => $validated['total_budget'],
            ]
        );

        return redirect()->route('sponsor.budget.index')
            ->with('success', 'Budget set successfully.');
    }

    public function update(Request $request, SponsorBudget $budget): RedirectResponse
    {
        if ($budget->sponsor_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'total_budget' => 'required|numeric|min:0',
        ]);

        $budget->update(['total_budget' => $validated['total_budget']]);

        return redirect()->route('sponsor.budget.index')
            ->with('success', 'Budget updated.');
    }
}
