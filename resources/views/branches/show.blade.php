@extends('layouts.app')
@section('content')
    <div class="min-h-screen bg-gray-50 px-4 py-8">
        <div class="mx-auto max-w-7xl">
            <!-- Back Button -->
            <div class="mb-8">
                <a href="{{ route('branch.index') }}"
                   class="inline-flex items-center text-gray-600 hover:text-gray-900">
                    <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                    Back to Branches
                </a>
            </div>

            <!-- Branch Header -->
            <div class="mb-8">
                <div class="flex items-start justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">{{ $branch->name }}</h1>
                        <div class="mt-2 flex items-center text-gray-600">
                            <svg class="mr-2 h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                            </svg>
                            <span>{{ $branch->address }}</span>
                        </div>
                    </div>
                    <a href="{{ route('branch.edit', $branch->id) }}"
                       class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
                        Edit Branch
                    </a>
                </div>

                <!-- Branch Details -->
                <div class="mt-6 grid grid-cols-1 gap-4 md:grid-cols-3">
                    @if($branch->manager)
                    <div class="rounded-lg border border-gray-200 bg-white p-4">
                        <div class="text-sm text-gray-500">Manager</div>
                        <div class="mt-1 font-medium text-gray-900">{{ $branch->manager }}</div>
                    </div>
                    @endif

                    @if($branch->phone)
                    <div class="rounded-lg border border-gray-200 bg-white p-4">
                        <div class="text-sm text-gray-500">Contact</div>
                        <div class="mt-1 font-medium text-gray-900">{{ $branch->phone }}</div>
                    </div>
                    @endif

                    <div class="rounded-lg border border-gray-200 bg-white p-4">
                        <div class="text-sm text-gray-500">Created</div>
                        <div class="mt-1 font-medium text-gray-900">{{ $branch->created_at->format('M d, Y') }}</div>
                    </div>
                </div>
            </div>

            <!-- Stats Overview -->
            <div class="mb-8 grid grid-cols-1 gap-6 md:grid-cols-3">
                <div class="rounded-lg border border-gray-200 bg-white p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-sm text-gray-500">Total Invoices</div>
                            <div class="mt-2 text-3xl font-bold text-gray-900">{{ $branch->invoices->count() }}</div>
                            <div class="mt-1 text-sm text-green-600">
                                {{ $branch->invoices->where('status', 'paid')->count() }} paid
                            </div>
                        </div>
                        <div class="rounded-lg bg-blue-100 p-3">
                            <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="rounded-lg border border-gray-200 bg-white p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-sm text-gray-500">Accountants</div>
                            <div class="mt-2 text-3xl font-bold text-gray-900">{{ $branch->accountants->count() }}</div>
                            <div class="mt-1 text-sm text-gray-500">Team members</div>
                        </div>
                        <div class="rounded-lg bg-emerald-100 p-3">
                            <svg class="h-6 w-6 text-emerald-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="rounded-lg border border-gray-200 bg-white p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-sm text-gray-500">Total Revenue</div>
                            <div class="mt-2 text-3xl font-bold text-gray-900">
                                {{ $branch->invoices->first()->currency ?? 'USD' }}
                                {{ number_format($branch->invoices->sum('total_amount'), 2) }}
                            </div>
                        </div>
                        <div class="rounded-lg bg-purple-100 p-3">
                            <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
                <!-- Invoices Section -->
                <div class="lg:col-span-2">
                    <div class="rounded-lg border border-gray-200 bg-white">
                        <div class="border-b border-gray-200 px-6 py-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h2 class="text-lg font-semibold text-gray-900">Invoices</h2>
                                    <p class="text-sm text-gray-500">All branch invoices</p>
                                </div>
                                <a href="{{ route('invoice.create', ['branch_id' => $branch->id]) }}"
                                   class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
                                    New Invoice
                                </a>
                            </div>
                        </div>

                        @if($branch->invoices->count())
                            <div class="divide-y divide-gray-200">
                                @foreach($branch->invoices as $invoice)
                                    <div class="px-6 py-4 hover:bg-gray-50">
                                        <div class="flex items-center justify-between">
                                            <div class="min-w-0 flex-1">
                                                <div class="flex items-center space-x-4">
                                                    <div class="flex-shrink-0">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            #{{ $invoice->invoice_number }}
                                                        </div>
                                                        <div class="text-xs text-gray-500">
                                                            {{ $invoice->created_at->format('M d, Y') }}
                                                        </div>
                                                    </div>
                                                    <div class="min-w-0 flex-1">
                                                        <div class="font-medium text-gray-900">
                                                            {{ $invoice->customer->name ?? 'N/A' }}
                                                        </div>
                                                        <div class="text-sm text-gray-500">
                                                            {{ $invoice->customer->email ?? 'No email' }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="ml-4 flex flex-col items-end">
                                                <div class="font-medium text-gray-900">
                                                    {{ $invoice->currency }} {{ number_format($invoice->total_amount, 2) }}
                                                </div>
                                                <div class="mt-1">
                                                    @if($invoice->status === 'paid')
                                                        <span class="inline-flex items-center rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800">
                                                            Paid
                                                        </span>
                                                    @elseif($invoice->status === 'pending')
                                                        <span class="inline-flex items-center rounded-full bg-yellow-100 px-2.5 py-0.5 text-xs font-medium text-yellow-800">
                                                            Pending
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-800">
                                                            {{ ucfirst($invoice->status) }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="ml-4">
                                                <a href="{{ route('invoice.show', $invoice->id) }}"
                                                   class="text-sm text-blue-600 hover:text-blue-900">
                                                    View
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="border-t border-gray-200 px-6 py-4">
                                <div class="flex items-center justify-between text-sm text-gray-500">
                                    <div>
                                        Showing {{ $branch->invoices->count() }} invoices
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <span class="text-green-600">
                                            Paid: {{ $branch->invoices->where('status', 'paid')->count() }}
                                        </span>
                                        <span class="text-yellow-600">
                                            Pending: {{ $branch->invoices->where('status', 'pending')->count() }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="px-6 py-12 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No invoices</h3>
                                <p class="mt-1 text-sm text-gray-500">Get started by creating a new invoice.</p>
                                <div class="mt-6">
                                    <a href="{{ route('invoice.create', ['branch_id' => $branch->id]) }}"
                                       class="inline-flex items-center rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
                                        Create Invoice
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Accountants Section -->
                <div>
                    <div class="rounded-lg border border-gray-200 bg-white">
                        <div class="border-b border-gray-200 px-6 py-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h2 class="text-lg font-semibold text-gray-900">Accountants</h2>
                                    <p class="text-sm text-gray-500">Branch team</p>
                                </div>
                                <button onclick="openModal('create-accountant-modal')"
                                        class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white hover:bg-emerald-700">
                                    Add Accountant
                                </button>
                            </div>
                        </div>

                        <div class="px-6 py-4">
                            @if($branch->accountants->count())
                                <ul class="divide-y divide-gray-200">
                                    @foreach($branch->accountants as $accountant)
                                        <li class="py-4">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center">
                                                    <div class="mr-3 flex h-10 w-10 items-center justify-center rounded-full bg-emerald-100 text-emerald-800">
                                                        {{ substr($accountant->name, 0, 1) }}
                                                    </div>
                                                    <div>
                                                        <div class="font-medium text-gray-900">{{ $accountant->name }}</div>
                                                        <div class="text-sm text-gray-500">{{ $accountant->email }}</div>
                                                    </div>
                                                </div>
                                                <form action="{{ route('branch.accountant.destroy', [$branch->id, $accountant->id]) }}"
                                                      method="POST"
                                                      onsubmit="return confirm('Remove {{ $accountant->name }}?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="text-sm text-red-600 hover:text-red-900">
                                                        Remove
                                                    </button>
                                                </form>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="py-8 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">No accountants</h3>
                                    <p class="mt-1 text-sm text-gray-500">Add accountants to manage this branch.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Accountant Modal -->
    <div id="create-accountant-modal"
         class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50 p-4">
        <div class="w-full max-w-md rounded-lg bg-white shadow-xl">
            <div class="border-b border-gray-200 px-6 py-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900">Add Accountant</h3>
                    <button onclick="closeModal('create-accountant-modal')"
                            class="text-gray-400 hover:text-gray-500">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <form action="{{ route('branch.accountant.store', $branch->id) }}" method="POST" class="px-6 py-4">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Full Name</label>
                        <input type="text" name="name" required
                               class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email Address</label>
                        <input type="email" name="email" required
                               class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>
                </div>

                <div class="mt-6 flex justify-end space-x-3">
                    <button type="button" onclick="closeModal('create-accountant-modal')"
                            class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit"
                            class="rounded-md bg-blue-600 px-4 py-2 text-sm font-medium text-white hover:bg-blue-700">
                        Add Accountant
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
            document.getElementById(id).classList.add('flex');
            document.body.classList.add('overflow-hidden');
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
            document.getElementById(id).classList.remove('flex');
            document.body.classList.remove('overflow-hidden');
        }

        // Close modal with Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeModal('create-accountant-modal');
            }
        });
    </script>
@endsection
