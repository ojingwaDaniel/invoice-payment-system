<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifyEmailController extends Controller
{
    public function __invoke(Request $request)
    {
        // Get the user ID from the URL
        $user = User::findOrFail($request->route('id'));

        // Validate signature
        if (!hash_equals(sha1($user->email), $request->route('hash'))) {
            abort(403, 'Invalid verification link');
        }

        // If already verified
        if ($user->hasVerifiedEmail()) {
            Auth::login($user);
            return redirect()->route('dashboard')->with('verified', true);
        }

        // Mark email as verified
        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }

        // Login the user automatically after verifying
        Auth::login($user);

        return redirect()->route('dashboard')->with('verified', true);
    }
}
