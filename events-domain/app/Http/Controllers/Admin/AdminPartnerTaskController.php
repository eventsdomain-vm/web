<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PartnerTask;
use Illuminate\Http\Request;

class AdminPartnerTaskController extends Controller
{
    public function index(Request $request)
    {
        $query = PartnerTask::with(['partner', 'assignedTo', 'sponsor', 'deal']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        if ($request->filled('search')) {
            $query->whereHas('partner', function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%");
            });
        }

        $tasks = $query->orderByDesc('created_at')->paginate(20);

        return view('admin.partner-tasks.index', compact('tasks'));
    }

    public function show(PartnerTask $task)
    {
        $task->load(['partner', 'assignedTo', 'sponsor', 'deal']);

        return view('admin.partner-tasks.show', compact('task'));
    }
}
