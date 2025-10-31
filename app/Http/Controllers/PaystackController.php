<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PaystackController extends Controller
{
    public function redirectToPaystack()
    {
        $clientId = config('services.paystack.public');
        $redirectUri = urlencode(route('paystack.callback'));
        $url = "https://dashboard.paystack.com/oauth/authorize?client_id={$clientId}&response_type=code&redirect_uri={$redirectUri}";
        return redirect($url);
    }

    public function handlePaystackCallback(Request $request)
    {
        $code = $request->query('code');

        $response = Http::post('https://api.paystack.co/oauth/token', [
            'grant_type' => 'authorization_code',
            'client_id' => config('services.paystack.public'),
            'client_secret' => config('services.paystack.secret'),
            'code' => $code,
            'redirect_uri' => route('paystack.callback'),
        ]);

        if (!$response->ok()) {
            return redirect()->route('dashboard')->with('error', 'Failed to connect Paystack.');
        }

        $data = $response->json();

        Auth::user()->update([
            'paystack_access_code' => $data['access_token'] ?? null,
            'paystack_subaccount_code' => $data['subaccount_code'] ?? null,
            'paystack_email' => $data['email'] ?? null,
            'paystack_auth_code' => $data['auth_code'] ?? null,
        ]);

        return redirect()->route('dashboard')->with('success', 'Paystack account connected successfully!');
    }
}
