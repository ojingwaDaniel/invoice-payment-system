@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 px-4 py-10">
        <div class="mx-auto max-w-6xl">
            @if ($errors->any())
                <div class="mb-4 rounded-lg bg-red-50 border border-red-200 p-4">
                    <ul class="list-disc list-inside text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Header -->
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Branches</h1>
                    <p class="mt-1 text-gray-500">Manage all company branches and their managers.</p>
                </div>

                <a href="{{ route('branch.create') }}"
                    class="inline-flex items-center rounded-xl bg-indigo-600 px-5 py-3 font-semibold text-white shadow-md transition hover:bg-indigo-700">
                    <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    New Branch
                </a>
            </div>

            <!-- Table Container -->
            <div class="overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-lg">

                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr class="text-left text-sm font-semibold text-gray-600">
                            <th class="px-6 py-4">Branch</th>
                            <th class="px-6 py-4">Manager</th>
                            <th class="px-6 py-4">Phone</th>
                            <th class="px-6 py-4">Accountants</th>
                            <th class="px-6 py-4">Created</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100 bg-white">

                        @forelse ($branches as $branch)
                            <tr class="transition hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <a href="{{ route('branch.show', $branch->id) }}"
                                       class="group block">
                                        <div class="font-semibold text-indigo-600 group-hover:text-indigo-800 transition">
                                            {{ $branch->name }}
                                            <svg class="inline-block ml-1 h-4 w-4 opacity-0 group-hover:opacity-100 transition"
                                                 fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </div>
                                        <div class="text-sm text-gray-500">{{ $branch->address }}</div>
                                    </a>
                                </td>

                                <td class="px-6 py-4 text-gray-700">
                                    {{ $branch->manager ?? '—' }}
                                </td>

                                <td class="px-6 py-4 text-gray-700">
                                    {{ $branch->phone ?? '—' }}
                                </td>

                                <td class="px-6 py-4">
                                    @if ($branch->accountants->count())
                                        <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-1 text-sm font-medium text-green-800">
                                            {{ $branch->accountants->count() }} accountant{{ $branch->accountants->count() > 1 ? 's' : '' }}
                                        </span>
                                    @else
                                        <span class="text-sm text-gray-400">None</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $branch->created_at->format('M d, Y') }}
                                </td>

                                <td class="px-6 py-4 text-right">

                                    <div class="inline-flex gap-3">



                                        <!-- Edit Button -->
                                        <a href="{{ route('branch.edit', $branch->id) }}"
                                            class="font-medium text-indigo-600 transition hover:text-indigo-800">
                                            Edit
                                        </a>

                                        <!-- Delete Button -->
                                        @if (!$branch->is_head_office)
                                            <form action="{{ route('branch.destroy', $branch->id) }}" method="POST"
                                                  onsubmit="return confirm('Are you sure you want to delete this branch?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="font-medium text-red-600 hover:text-red-800">Delete</button>
                                            </form>
                                        @endif

                                    </div>

                                </td>

                            </tr>

                        @empty
                            <!-- Empty State -->
                            <tr>
                                <td colspan="6" class="py-20 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="mb-4 rounded-full bg-gray-100 p-6">
                                            <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                                stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M4 6h16M4 12h16M4 18h7" />
                                            </svg>
                                        </div>

                                        <h3 class="text-xl font-semibold text-gray-700">No branches created yet</h3>
                                        <p class="mt-2 text-gray-500">Start by adding your first company branch.</p>

                                        <a href="{{ route('branch.create') }}"
                                            class="mt-6 rounded-xl bg-indigo-600 px-6 py-3 font-semibold text-white shadow transition hover:bg-indigo-700">
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
