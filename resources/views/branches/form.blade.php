@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-10 px-4">
    <div class="max-w-3xl mx-auto">

        <!-- Card -->
        <div class="bg-white shadow-lg rounded-2xl p-8 border border-gray-100">

            <!-- Title -->
            <div class="flex items-center justify-between mb-8">
                <h1 class="text-2xl font-bold text-gray-800">
                    {{ isset($branch) ? 'Edit Branch' : 'Create New Branch' }}
                </h1>

                <a href="{{ route('branch.index') }}"
                    class="text-sm px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg font-medium">
                    Back
                </a>
            </div>

            <!-- Form -->
            <form
                action="{{ isset($branch) ? route('branch.update', $branch->id) : route('branch.store') }}"
                method="POST"
                class="space-y-6"
            >
                @csrf
                @if(isset($branch))
                    @method('PUT')
                @endif

                <!-- Branch Name -->
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Branch Name</label>
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name', $branch->name ?? '') }}"
                        placeholder="e.g., Lekki Branch"
                        class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition"
                    >
                    @error('name')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Branch Manager -->
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Branch Manager</label>
                    <input
                        type="text"
                        name="manager"
                        value="{{ old('manager', $branch->manager ?? '') }}"
                        placeholder="e.g., Daniel Obi"
                        class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition"
                    >
                    @error('manager')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Phone Number</label>
                    <input
                        type="text"
                        name="phone"
                        value="{{ old('phone', $branch->phone ?? '') }}"
                        placeholder="+234 812 345 6789"
                        class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition"
                    >
                    @error('phone')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address -->
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Address</label>
                    <textarea
                        name="address"
                        rows="3"
                        placeholder="e.g., 12 Admiralty Way, Lekki Phase 1"
                        class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition"
                    >{{ old('address', $branch->address ?? '') }}</textarea>
                    @error('address')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="pt-4 flex items-center justify-end gap-4">
                    <a
                        href="{{ route('branch.index') }}"
                        class="px-5 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-xl font-medium transition"
                    >
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-semibold shadow-md transition"
                    >
                        {{ isset($branch) ? 'Update Branch' : 'Create Branch' }}
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection
