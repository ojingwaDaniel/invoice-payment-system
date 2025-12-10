@extends('layouts.app')

@section('content')
    <div class="px-6 py-8">
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Activity Log</h1>
            <p class="mt-1 text-sm text-gray-600">Track all system activities and changes</p>
        </div>

        <!-- FILTERS -->
        <div class="mb-6 rounded-xl bg-white p-6 shadow-sm border border-gray-200">
            <form method="GET" class="space-y-4">
                <div class="grid grid-cols-1 gap-4 md:grid-cols-4">

                    <!-- Search -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Search</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search by user, activity..."
                            class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition">
                    </div>

                    <!-- User Filter -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">User</label>
                        <select name="user_id" class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition">
                            <option value="">All Users</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Module Filter -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Module</label>
                        <select name="model" class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition">
                            <option value="">All Modules</option>
                            <option value="Invoice" {{ request('model') == 'Invoice' ? 'selected' : '' }}>Invoice</option>
                            <option value="Customer" {{ request('model') == 'Customer' ? 'selected' : '' }}>Customer</option>
                            <option value="Branch" {{ request('model') == 'Branch' ? 'selected' : '' }}>Branch</option>
                            <option value="User" {{ request('model') == 'User' ? 'selected' : '' }}>User</option>
                        </select>
                    </div>

                    <!-- Action Filter -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Action</label>
                        <select name="event" class="w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition">
                            <option value="">All Actions</option>
                            <option value="created" {{ request('event') == 'created' ? 'selected' : '' }}>Created</option>
                            <option value="updated" {{ request('event') == 'updated' ? 'selected' : '' }}>Updated</option>
                            <option value="deleted" {{ request('event') == 'deleted' ? 'selected' : '' }}>Deleted</option>
                        </select>
                    </div>
                </div>

                <!-- Filter Buttons -->
                <div class="flex gap-3">
                    <button type="submit" class="rounded-lg bg-blue-600 px-6 py-2.5 text-sm font-semibold text-white hover:bg-blue-700 transition shadow-sm">
                        Apply Filters
                    </button>
                    <a href="{{ url()->current() }}" class="rounded-lg bg-gray-100 px-6 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-200 transition">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- LOG TABLE -->
        <div class="overflow-hidden rounded-xl bg-white shadow-sm border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">User</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Activity</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Module</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Time</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($logs as $log)
                        <tr class="hover:bg-gray-50 transition">
                            <!-- User -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <span class="text-blue-600 font-semibold text-sm">
                                            {{ strtoupper(substr($log->causer?->name ?? 'S', 0, 2)) }}
                                        </span>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-semibold text-gray-900">{{ $log->causer?->name ?? 'System' }}</div>
                                        <div class="text-xs text-gray-500">{{ $log->causer?->email ?? 'Automated Action' }}</div>
                                    </div>
                                </div>
                            </td>

                            <!-- Activity -->
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900">
                                    @php
                                        $event = $log->event ?? $log->description;
                                        $subjectType = class_basename($log->subject_type ?? $log->model);
                                    @endphp

                                    @if($event == 'created')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 mr-2">
                                            Created
                                        </span>
                                    @elseif($event == 'updated')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mr-2">
                                            Updated
                                        </span>
                                    @elseif($event == 'deleted')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 mr-2">
                                            Deleted
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 mr-2">
                                            {{ ucfirst($event) }}
                                        </span>
                                    @endif

                                    <span class="text-gray-700">{{ $log->description ?? ucfirst($event) . ' ' . $subjectType }}</span>
                                </div>
                            </td>

                            <!-- Module -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-3 py-1 rounded-md text-xs font-medium bg-purple-50 text-purple-700 border border-purple-200">
                                    {{ class_basename($log->subject_type ?? $log->model) }}
                                </span>
                            </td>

                            <!-- Time -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div>{{ $log->created_at->format('M d, Y') }}</div>
                                <div class="text-xs text-gray-400">{{ $log->created_at->format('h:i A') }}</div>
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <button onclick="toggleDetails('{{ $log->id }}')" id="btn-{{ $log->id }}"
                                    class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium text-blue-700 bg-blue-50 hover:bg-blue-100 transition">
                                    <svg class="w-4 h-4 mr-1 view-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <svg class="w-4 h-4 mr-1 close-icon hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    <span class="btn-text">View Details</span>
                                </button>
                            </td>
                        </tr>

                        <!-- Expandable Details Row -->
                        <tr id="details-row-{{ $log->id }}" class="hidden">
                            <td colspan="5" class="px-6 py-4 bg-gray-50">
                                <div class="rounded-lg bg-white p-6 shadow-inner border border-gray-200">

                                    <!-- Activity Summary Section -->
                                    <div class="mb-6 pb-6 border-b border-gray-200">
                                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Activity Summary</h3>
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                            <div class="bg-blue-50 rounded-lg p-4 border border-blue-100">
                                                <div class="text-xs font-semibold text-blue-600 uppercase mb-1">Performed By</div>
                                                <div class="text-sm font-bold text-gray-900">{{ $log->causer?->name ?? 'System' }}</div>
                                                <div class="text-xs text-gray-600">{{ $log->causer?->email ?? 'Automated' }}</div>
                                                @if($log->causer?->role)
                                                    <div class="mt-1">
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                                            {{ $log->causer->role }}
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="bg-purple-50 rounded-lg p-4 border border-purple-100">
                                                <div class="text-xs font-semibold text-purple-600 uppercase mb-1">Action Type</div>
                                                <div class="text-sm font-bold text-gray-900">{{ ucfirst($log->event ?? $log->description) }}</div>
                                                <div class="text-xs text-gray-600">{{ class_basename($log->subject_type ?? $log->model) }} Module</div>
                                            </div>

                                            <div class="bg-green-50 rounded-lg p-4 border border-green-100">
                                                <div class="text-xs font-semibold text-green-600 uppercase mb-1">Timestamp</div>
                                                <div class="text-sm font-bold text-gray-900">{{ $log->created_at->format('M d, Y h:i A') }}</div>
                                                <div class="text-xs text-gray-600">{{ $log->created_at->diffForHumans() }}</div>
                                            </div>
                                        </div>

                                        @if($log->subject_id)
                                            <div class="mt-4 bg-gray-50 rounded-lg p-3 border border-gray-200">
                                                <span class="text-xs font-semibold text-gray-600 uppercase">Record ID:</span>
                                                <span class="text-sm font-mono text-gray-900 ml-2">#{{ $log->subject_id }}</span>
                                            </div>
                                        @endif
                                    </div>

                                    @php
                                        $oldValues = $log->properties['old'] ?? $log->old_values ?? [];
                                        $newValues = $log->properties['attributes'] ?? $log->new_values ?? [];
                                    @endphp

                                    @if (!empty($oldValues) || !empty($newValues))
                                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Change Details</h3>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <!-- Old Values -->
                                            @if (!empty($oldValues))
                                                <div>
                                                    <div class="flex items-center mb-3">
                                                        <div class="h-8 w-8 rounded-full bg-red-100 flex items-center justify-center mr-3">
                                                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                            </svg>
                                                        </div>
                                                        <h4 class="text-sm font-bold text-gray-900">Previous Values</h4>
                                                    </div>
                                                    <div class="space-y-2 pl-11">
                                                        @foreach ($oldValues as $key => $value)
                                                            @if(!in_array($key, ['user_id', 'company_id', 'created_at', 'updated_at']))
                                                                <div class="flex items-start">
                                                                    <span class="text-xs font-semibold text-gray-600 uppercase tracking-wide min-w-[120px]">{{ str_replace('_', ' ', $key) }}:</span>
                                                                    <span class="text-sm text-gray-800 ml-2 break-all">
                                                                        @if(is_null($value) || $value === '')
                                                                            <span class="text-gray-400 italic">empty</span>
                                                                        @elseif(is_bool($value))
                                                                            {{ $value ? 'Yes' : 'No' }}
                                                                        @elseif($key === 'created_by')
                                                                            @php
                                                                                $creator = \App\Models\User::find($value);
                                                                            @endphp
                                                                            {{ $creator?->name ?? 'User #' . $value }}
                                                                        @elseif($key === 'branch_id')
                                                                            @php
                                                                                $branch = \App\Models\Branch::find($value);
                                                                            @endphp
                                                                            {{ $branch?->name ?? 'Branch #' . $value }}
                                                                        @elseif($key === 'customer_id')
                                                                            @php
                                                                                $customer = \App\Models\Customer::find($value);
                                                                            @endphp
                                                                            {{ $customer?->name ?? 'Customer #' . $value }}
                                                                        @elseif(in_array($key, ['total_amount', 'paid', 'vat_amount', 'discount', 'amount', 'price', 'subtotal']))
                                                                            {{ number_format($value, 2) }}
                                                                        @elseif(in_array($key, ['issue_date', 'due_date', 'paid_at']) && $value)
                                                                            @php
                                                                                try {
                                                                                    $date = \Carbon\Carbon::parse($value);
                                                                                    echo $date->format('M d, Y');
                                                                                } catch (\Exception $e) {
                                                                                    echo $value;
                                                                                }
                                                                            @endphp
                                                                        @else
                                                                            {{ $value }}
                                                                        @endif
                                                                    </span>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- New Values -->
                                            @if (!empty($newValues))
                                                <div>
                                                    <div class="flex items-center mb-3">
                                                        <div class="h-8 w-8 rounded-full bg-green-100 flex items-center justify-center mr-3">
                                                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                            </svg>
                                                        </div>
                                                        <h4 class="text-sm font-bold text-gray-900">Updated Values</h4>
                                                    </div>
                                                    <div class="space-y-2 pl-11">
                                                        @foreach ($newValues as $key => $value)
                                                            @if(!in_array($key, ['user_id', 'company_id', 'created_at', 'updated_at']))
                                                                <div class="flex items-start">
                                                                    <span class="text-xs font-semibold text-gray-600 uppercase tracking-wide min-w-[120px]">{{ str_replace('_', ' ', $key) }}:</span>
                                                                    <span class="text-sm text-gray-800 ml-2 break-all font-medium">
                                                                        @if(is_null($value) || $value === '')
                                                                            <span class="text-gray-400 italic">empty</span>
                                                                        @elseif(is_bool($value))
                                                                            {{ $value ? 'Yes' : 'No' }}
                                                                        @elseif($key === 'created_by')
                                                                            @php
                                                                                $creator = \App\Models\User::find($value);
                                                                            @endphp
                                                                            {{ $creator?->name ?? 'User #' . $value }}
                                                                        @elseif($key === 'branch_id')
                                                                            @php
                                                                                $branch = \App\Models\Branch::find($value);
                                                                            @endphp
                                                                            {{ $branch?->name ?? 'Branch #' . $value }}
                                                                        @elseif($key === 'customer_id')
                                                                            @php
                                                                                $customer = \App\Models\Customer::find($value);
                                                                            @endphp
                                                                            {{ $customer?->name ?? 'Customer #' . $value }}
                                                                        @elseif(in_array($key, ['total_amount', 'paid', 'vat_amount', 'discount', 'amount', 'price', 'subtotal']))
                                                                            {{ number_format($value, 2) }}
                                                                        @elseif(in_array($key, ['issue_date', 'due_date', 'paid_at']) && $value)
                                                                            @php
                                                                                try {
                                                                                    $date = \Carbon\Carbon::parse($value);
                                                                                    echo $date->format('M d, Y');
                                                                                } catch (\Exception $e) {
                                                                                    echo $value;
                                                                                }
                                                                            @endphp
                                                                        @else
                                                                            {{ $value }}
                                                                        @endif
                                                                    </span>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Highlight Changed Fields -->
                                        @if (!empty($oldValues) && !empty($newValues))
                                            <div class="mt-6 pt-6 border-t border-gray-200">
                                                <h4 class="text-sm font-bold text-gray-900 mb-3">Changed Fields Summary</h4>
                                                <div class="flex flex-wrap gap-2">
                                                    @foreach ($newValues as $key => $value)
                                                        @if(!in_array($key, ['user_id', 'company_id', 'created_at', 'updated_at']) && isset($oldValues[$key]) && $oldValues[$key] != $value)
                                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-800 border border-amber-200">
                                                                {{ str_replace('_', ' ', ucfirst($key)) }}
                                                            </span>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    @else
                                        <div class="text-center py-8">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                            </svg>
                                            <p class="mt-2 text-sm text-gray-500">No change details available for this activity.</p>
                                        </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <p class="mt-2 text-sm font-medium text-gray-900">No activities found</p>
                                <p class="mt-1 text-sm text-gray-500">Try adjusting your filters to see more results.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                {{ $logs->links() }}
            </div>
        </div>
    </div>

    <script>
        function toggleDetails(id) {
            const detailsRow = document.getElementById("details-row-" + id);
            const button = document.getElementById("btn-" + id);
            const btnText = button.querySelector('.btn-text');
            const viewIcon = button.querySelector('.view-icon');
            const closeIcon = button.querySelector('.close-icon');

            detailsRow.classList.toggle("hidden");

            if (detailsRow.classList.contains("hidden")) {
                btnText.textContent = "View Details";
                viewIcon.classList.remove("hidden");
                closeIcon.classList.add("hidden");
            } else {
                btnText.textContent = "Close Details";
                viewIcon.classList.add("hidden");
                closeIcon.classList.remove("hidden");
            }
        }
    </script>
@endsection
