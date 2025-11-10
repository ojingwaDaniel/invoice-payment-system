@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">Profile Settings</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf

            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="text" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>

            </div>

            <div class="mb-3">
                <label>Company Name</label>
                <input type="text" name="company_name" class="form-control"
                    value="{{ old('company_name', $user->company_name) }}">
            </div>

            <div class="mb-3">
                <label>Phone</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
            </div>

            <div class="mb-3">
                <label>Address</label>
                <input type="text" name="address" class="form-control" value="{{ old('address', $user->address) }}">
            </div>

            <button type="submit" class="btn btn-primary">Update Profile</button>
        </form>
        <form action="{{ route('profile.updatePaystackKeys') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="public_key" class="form-label">Paystack Public Key</label>
                <div class="input-group" style="max-width: 500px;">
                    <input type="password" id="public_key" name="paystack_public_key"
                        value="{{ old('paystack_public_key', auth()->user()->paystack_public_key) }}" class="form-control"
                        readonly>
                    <button type="button" class="btn btn-outline-secondary" onclick="toggleKey('public_key')">
                        Show
                    </button>
                </div>
            </div>

            <div class="mb-3">
                <label for="secret_key" class="form-label">Paystack Secret Key</label>
                <div class="input-group" style="max-width: 500px;">
                    <input type="password" id="secret_key" name="paystack_secret_key"
                        value="{{ old('paystack_secret_key', auth()->user()->paystack_secret_key) }}" class="form-control"
                        readonly>
                    <button type="button" class="btn btn-outline-secondary" onclick="toggleKey('secret_key')">
                        Show
                    </button>
                </div>
            </div>

            <script>
                function toggleKey(id) {
                    const input = document.getElementById(id);
                    if (input.type === 'password') {
                        input.type = 'text';
                        input.removeAttribute('readonly'); // optional: allow editing
                    } else {
                        input.type = 'password';
                        input.setAttribute('readonly', true); // restore readonly
                    }
                }
            </script>

    </div>
@endsection
