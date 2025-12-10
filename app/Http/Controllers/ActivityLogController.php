<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use App\Models\User;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = Activity::with('causer');

        if ($request->search) {
            $query->where('description', 'like', "%{$request->search}%");
        }

        if ($request->user_id) {
            $query->where('causer_id', $request->user_id);
        }

        if ($request->model) {
            $query->where('subject_type', 'like', "%{$request->model}%");
        }

        if ($request->event) {
            $query->where('event', $request->event);
        }

        return view('admin.activity-log.index', [
            'logs' => $query->latest()->paginate(20),
            'users' => User::all(),
        ]);
    }
}
