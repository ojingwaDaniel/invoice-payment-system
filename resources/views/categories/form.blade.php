@extends('layouts.app')

@section('content')
<div class="page-wrapper p-6 bg-gray-50 min-h-screen">
    <div class="max-w-xl mx-auto bg-white rounded-2xl shadow-sm p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">
            {{ isset($category) ? 'Edit Category' : 'Create Category' }}
        </h2>

        @if ($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                <ul class="list-disc ml-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST"
              action="{{ isset($category) ? route('category.update', $category->id) : route('category.store') }}">
            @csrf
            @if(isset($category))
                @method('PUT')
            @endif

            <div class="mb-5">
                <label class="block text-gray-700 font-medium mb-2">Category Name</label>
                <input type="text" name="name" value="{{ old('name', $category->name ?? '') }}"
                       class="w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-primary-500 focus:outline-none"
                       placeholder="Enter category name" required>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('category.index') }}"
                   class="px-4 py-2 bg-gray-200 rounded-lg text-gray-700 hover:bg-gray-300 transition">
                    Cancel
                </a>
                <button type="submit"
                        class="px-4 py-2 bg-primary-600 text-white rounded-lg shadow hover:bg-primary-700 transition">
                    {{ isset($category) ? 'Update' : 'Create' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
