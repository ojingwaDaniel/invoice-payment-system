@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto bg-white shadow-lg rounded-lg p-6 mt-10">
    <h2 class="text-2xl font-semibold mb-6 text-gray-800">
        {{ isset($unit) ? 'Edit Unit' : 'Create New Unit' }}
    </h2>

    <form
        action="{{ isset($unit) ? route('unit.update', $unit->id) : route('unit.store') }}"
        method="POST"
    >
        @csrf
        @if(isset($unit))
            @method('PUT')
        @endif

        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Unit Name</label>
            <input
                type="text"
                name="name"
                id="name"
                value="{{ old('name', $unit->name ?? '') }}"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                required
            >
        </div>

        <div class="mb-4">
            <label for="short_name" class="block text-sm font-medium text-gray-700">Short Name</label>
            <input
                type="text"
                name="short_name"
                id="short_name"
                value="{{ old('short_name', $unit->short_name ?? '') }}"
                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            >
        </div>

        <div class="flex justify-end">
            <button
                type="submit"
                class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition-colors"
            >
                {{ isset($unit) ? 'Update Unit' : 'Create Unit' }}
            </button>
        </div>
    </form>
</div>
@endsection
