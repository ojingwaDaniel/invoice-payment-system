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
            <input type="text" name="email" class="form-control" value="{{ old('name', $user->email) }}" required>
        </div>

        <div class="mb-3">
            <label>Company Name</label>
            <input type="text" name="company_name" class="form-control" value="{{ old('company_name', $user->company_name) }}">
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

    <hr class="my-4">

    <h4>Paystack Connection</h4>
    @if (!$user->paystack_subaccount_code)
        <a href="{{ route('paystack.connect') }}" class="btn btn-outline-success">
            Connect Paystack Account
        </a>
    @else
        <div class="alert alert-success">
            ✅ Paystack Connected Successfully<br>
            <small>Subaccount Code: {{ $user->paystack_subaccount_code }}</small>
        </div>
    @endif
</div>
@endsection
