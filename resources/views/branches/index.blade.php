@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-10 px-4">
    <div class="max-w-6xl mx-auto">

        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Branches</h1>
                <p class="text-gray-500 mt-1">Manage all company branches and their managers.</p>
            </div>

            <a href="{{ route('branch.create') }}"
                class="inline-flex items-center px-5 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-semibold shadow-md transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                New Branch
            </a>
        </div>

        <!-- Table Container -->
        <div class="bg-white border border-gray-100 shadow-lg rounded-2xl overflow-hidden">

            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr class="text-left text-sm font-semibold text-gray-600">
                        <th class="px-6 py-4">Branch</th>
                        <th class="px-6 py-4">Manager</th>
                        <th class="px-6 py-4">Phone</th>
                        <th class="px-6 py-4">Created</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100 bg-white">

                    @forelse ($branches as $branch)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <div class="font-semibold text-gray-900">{{ $branch->name }}</div>
                            <div class="text-sm text-gray-500">{{ $branch->address }}</div>
                        </td>

                        <td class="px-6 py-4 text-gray-700">
                            {{ $branch->manager ?? '—' }}
                        </td>

                        <td class="px-6 py-4 text-gray-700">
                            {{ $branch->phone ?? '—' }}
                        </td>

                        <td class="px-6 py-4 text-gray-600 text-sm">
                            {{ $branch->created_at->format('M d, Y') }}
                        </td>

                        <td class="px-6 py-4 text-right">

                            <div class="inline-flex gap-3">

                                <!-- Edit Button -->
                                <a href="{{ route('branch.edit', $branch->id) }}"
                                    class="text-indigo-600 hover:text-indigo-800 font-medium transition">
                                    Edit
                                </a>

                                <!-- Delete Button -->
                                <form action="{{ route('branch.destroy', $branch->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this branch? This action cannot be undone.');">
                                    @csrf
                                    @method('DELETE')

                                    <button class="text-red-600 hover:text-red-800 font-medium transition">
                                        Delete
                                    </button>
                                </form>

                            </div>

                        </td>
                    </tr>

                    @empty
                    <!-- Empty State -->
                    <tr>
                        <td colspan="5" class="py-20 text-center">
                            <div class="flex flex-col items-center">
                                <div class="bg-gray-100 p-6 rounded-full mb-4">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                        stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M4 6h16M4 12h16M4 18h7" />
                                    </svg>
                                </div>

                                <h3 class="text-xl font-semibold text-gray-700">No branches created yet</h3>
                                <p class="text-gray-500 mt-2">Start by adding your first company branch.</p>

                                <a href="{{ route('branch.create') }}"
                                    class="mt-6 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-semibold shadow transition">
                                    Create Branch
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

    </div>
</div>
@endsection
