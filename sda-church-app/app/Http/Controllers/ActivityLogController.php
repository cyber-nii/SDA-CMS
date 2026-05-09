<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $activities = ActivityLog::with('user')
            ->when($search, fn ($q) => $q->where('action', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%"))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('activity.index', compact('activities', 'search'));
    }
}
