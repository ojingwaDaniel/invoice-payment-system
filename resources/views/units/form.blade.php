@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto bg-white shadow-xl rounded-2xl p-8 mt-12 border border-gray-100">

    <h2 class="text-3xl font-bold mb-8 text-gray-900 tracking-tight flex items-center gap-2">
        <span class="inline-block w-1.5 h-8 bg-indigo-600 rounded-full"></span>
        {{ isset($unit) ? 'Edit Unit' : 'Create New Unit' }}
    </h2>

    <form
        action="{{ isset($unit) ? route('unit.update', $unit->id) : route('unit.store') }}"
        method="POST"
        class="space-y-6"
    >
        @csrf
        @if(isset($unit))
            @method('PUT')
        @endif

        <!-- Unit Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                Unit Name <span class="text-red-500">*</span>
            </label>

            <input
                type="text"
                name="name"
                id="name"
                value="{{ old('name', $unit->name ?? '') }}"
                required
                class="block w-full rounded-xl border-gray-300 bg-gray-50 px-4 py-3 text-sm
                       focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                placeholder="Enter full unit name"
            >
        </div>

        <!-- Short Name -->
        <div>
            <label for="short_name" class="block text-sm font-medium text-gray-700 mb-1">
                Short Name
            </label>

            <input
                type="text"
                name="short_name"
                id="short_name"
                value="{{ old('short_name', $unit->short_name ?? '') }}"
                class="block w-full rounded-xl border-gray-300 bg-gray-50 px-4 py-3 text-sm
                       focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all"
                placeholder="e.g. KG, PCS, LTR"
            >
        </div>

        <!-- Submit Button -->
        <div class="pt-4 flex justify-end">
            <button
                type="submit"
                class="px-6 py-3 rounded-xl bg-indigo-600 text-white font-medium tracking-wide
                       hover:bg-indigo-700 active:scale-95 transition-all shadow-md hover:shadow-lg"
            >
                {{ isset($unit) ? 'Update Unit' : 'Create Unit' }}
            </button>
        </div>

    </form>
</div>

@endsection
