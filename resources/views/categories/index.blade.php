@extends('layouts.app')

@section('content')
<div class="page-wrapper p-6 bg-gray-50 min-h-screen">
    <div class="max-w-5xl mx-auto bg-white rounded-2xl shadow-sm p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Categories</h2>
            <a href="{{ route('category.create') }}"
               class="px-4 py-2 bg-primary-600 text-white rounded-lg shadow hover:bg-primary-700 transition">
                + Add Category
            </a>
        </div>

        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full border-collapse bg-white">
                <thead>
                    <tr class="bg-gray-100 text-left text-sm font-semibold text-gray-600 uppercase tracking-wider">
                        <th class="p-3 rounded-tl-lg">#</th>
                        <th class="p-3">Category Name</th>
                        <th class="p-3">Products Count</th>
                        <th class="p-3 text-right rounded-tr-lg">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-700">
                    @forelse ($categories as $index => $category)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="p-3">{{ $index + 1 }}</td>
                            <td class="p-3 font-medium">{{ $category->name }}</td>
                            <td class="p-3">{{ $category->products_count }}</td>
                            <td class="p-3 text-right space-x-2">
                                <a href="{{ route('category.edit', $category->id) }}"
                                   class="text-blue-500 hover:text-blue-700 font-semibold transition">Edit</a>
                                <form action="{{ route('category.destroy', $category->id) }}" method="POST"
                                      class="inline"
                                      onsubmit="return confirm('Are you sure you want to delete this category?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-red-500 hover:text-red-700 font-semibold transition">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-6 text-gray-500">
                                No categories found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
