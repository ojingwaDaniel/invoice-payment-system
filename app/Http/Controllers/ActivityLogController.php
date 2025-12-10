<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use App\Models\User;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::with('user');

        if ($request->search) {
            // Assuming you want to search in 'action' or 'model'
            $query->where(function ($q) use ($request) {
                $q->where('action', 'like', "%{$request->search}%")
                    ->orWhere('model', 'like', "%{$request->search}%");
            });
        }

        if ($request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->model) {
            $query->where('model', 'like', "%{$request->model}%");
        }

        if ($request->event) {
            // Assuming 'event' is equivalent to 'action'
            $query->where('action', $request->event);
        }

        return view('admin.activity-log.index', [
            'logs' => $query->latest()->paginate(20),
            'users' => User::all(),
        ]);
    }
}
