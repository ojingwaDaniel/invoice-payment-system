@extends('layouts.app')

@section('content')
    <div class="px-6 py-8">
        <h1 class="mb-6 text-2xl font-bold">Activity Log</h1>

        <!-- FILTERS -->
        <div class="mb-6 rounded-xl bg-white p-4 shadow-md">
            <form method="GET" class="grid grid-cols-1 gap-4 md:grid-cols-4">

                <!-- Search -->
                <div>
                    <label class="text-sm font-medium">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search activity or user..."
                        class="mt-1 w-full rounded-lg border px-3 py-2 focus:ring focus:ring-blue-200">
                </div>

                <!-- User Filter -->
                <div>
                    <label class="text-sm font-medium">User</label>
                    <select name="user_id" class="mt-1 w-full rounded-lg border px-3 py-2">
                        <option value="">All Users</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Model Filter -->
                <div>
                    <label class="text-sm font-medium">Module</label>
                    <select name="model" class="mt-1 w-full rounded-lg border px-3 py-2">
                        <option value="">All Modules</option>
                        <option value="Invoice" {{ request('model') == 'Invoice' ? 'selected' : '' }}>Invoice</option>
                        <option value="Customer" {{ request('model') == 'Customer' ? 'selected' : '' }}>Customer</option>
                        <option value="Branch" {{ request('model') == 'Branch' ? 'selected' : '' }}>Branch</option>
                        <option value="User" {{ request('model') == 'User' ? 'selected' : '' }}>User</option>
                    </select>
                </div>

                <!-- Action Filter -->
                <div>
                    <label class="text-sm font-medium">Action</label>
                    <select name="event" class="mt-1 w-full rounded-lg border px-3 py-2">
                        <option value="">All</option>
                        <option value="created" {{ request('event') == 'created' ? 'selected' : '' }}>Created</option>
                        <option value="updated" {{ request('event') == 'updated' ? 'selected' : '' }}>Updated</option>
                        <option value="deleted" {{ request('event') == 'deleted' ? 'selected' : '' }}>Deleted</option>
                    </select>
                </div>

                <!-- Filter Button -->
                <div class="md:col-span-4">
                    <button class="rounded-lg bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
                        Apply Filters
                    </button>
                </div>
            </form>
        </div>

        <!-- LOG TABLE -->
        <div class="overflow-hidden rounded-xl bg-white shadow-md">
            <table class="min-w-full">
                <thead class="border-b bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium">User</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Activity</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Module</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Time</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Details</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($logs as $log)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <div class="font-medium">{{ $log->causer?->name ?? 'System' }}</div>
                                <div class="text-xs text-gray-500">{{ $log->causer?->role }}</div>
                            </td>

                            <td class="px-6 py-4">
                                {{ $log->description }}
                            </td>

                            <td class="px-6 py-4">
                                {{ class_basename($log->subject_type) }}
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $log->created_at->diffForHumans() }}
                            </td>

                            <td class="px-6 py-4">
                                <button onclick="toggleDetails('{{ $log->id }}')"
                                    class="text-sm text-blue-600 hover:underline">
                                    View
                                </button>

                                <div id="details-{{ $log->id }}"
                                    class="mt-3 hidden rounded-lg bg-gray-100 p-4 text-sm">
                                    @php
                                        $properties = collect($log->properties ?? []);
                                    @endphp

                                    @if ($properties->has('old') || $properties->has('attributes'))
                                        <div class="grid grid-cols-2 gap-4">

                                            <!-- Old Values -->
                                            <div>
                                                <h4 class="mb-2 font-bold">Old Values</h4>
                                                <ul class="text-xs text-gray-700">
                                                    @foreach ($log->properties['old'] ?? [] as $key => $value)
                                                        <li><strong>{{ $key }}:</strong> {{ $value }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>

                                            <!-- New Values -->
                                            <div>
                                                <h4 class="mb-2 font-bold">New Values</h4>
                                                <ul class="text-xs text-gray-700">
                                                    @foreach ($log->properties['attributes'] ?? [] as $key => $value)
                                                        <li><strong>{{ $key }}:</strong> {{ $value }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>

                                        </div>
                                    @else
                                        <div class="text-xs text-gray-500">No details available.</div>
                                    @endif

                                </div>

                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                No activities found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="p-4">
                {{ $logs->links() }}
            </div>
        </div>
    </div>

    <script>
        function toggleDetails(id) {
            const box = document.getElementById("details-" + id);
            box.classList.toggle("hidden");
        }
    </script>
@endsection
