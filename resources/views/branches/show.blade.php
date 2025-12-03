@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 px-4 py-10">
        <div class="mx-auto max-w-7xl">

            <!-- Back Button -->
            <a href="{{ route('branch.index') }}"
               class="inline-flex items-center text-gray-600 hover:text-gray-900 mb-6 transition">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Back to Branches
            </a>

            <!-- Branch Header -->
            <div class="mb-8 rounded-2xl bg-gradient-to-r from-indigo-500 to-purple-600 p-8 shadow-xl text-white">
                <div class="flex items-start justify-between">
                    <div>
                        <h1 class="text-4xl font-bold mb-2">{{ $branch->name }}</h1>
                        <p class="text-indigo-100 text-lg mb-4">{{ $branch->address }}</p>

                        <div class="flex gap-6 text-sm">
                            @if($branch->manager)
                                <div class="flex items-center">
                                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <span>Manager: {{ $branch->manager }}</span>
                                </div>
                            @endif

                            @if($branch->phone)
                                <div class="flex items-center">
                                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    <span>{{ $branch->phone }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <a href="{{ route('branch.edit', $branch->id) }}"
                           class="inline-flex items-center rounded-lg bg-white bg-opacity-20 backdrop-blur-sm px-4 py-2 font-semibold text-white hover:bg-opacity-30 transition">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit Branch
                        </a>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Invoices</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $branch->invoices->count() }}</p>
                        </div>
                        <div class="rounded-full bg-blue-100 p-3">
                            <svg class="h-8 w-8 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Accountants</p>
                            <p class="text-3xl font-bold text-gray-900 mt-2">{{ $branch->accountants->count() }}</p>
                        </div>
                        <div class="rounded-full bg-green-100 p-3">
                            <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Created</p>
                            <p class="text-2xl font-bold text-gray-900 mt-2">{{ $branch->created_at->format('M d, Y') }}</p>
                        </div>
                        <div class="rounded-full bg-purple-100 p-3">
                            <svg class="h-8 w-8 text-purple-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Invoices Section -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="border-b border-gray-100 bg-gray-50 px-6 py-4 flex items-center justify-between">
                            <h2 class="text-xl font-bold text-gray-900">Invoices</h2>
                            <a href="{{ route('invoice.create', ['branch_id' => $branch->id]) }}"
                               class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700 transition">
                                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                </svg>
                                New Invoice
                            </a>
                        </div>

                        @if($branch->invoices->count())
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr class="text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            <th class="px-6 py-3">Invoice #</th>
                                            <th class="px-6 py-3">Customer</th>
                                            <th class="px-6 py-3">Amount</th>
                                            <th class="px-6 py-3">Status</th>
                                            <th class="px-6 py-3">Date</th>
                                            <th class="px-6 py-3 text-right">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100 bg-white">
                                        @foreach($branch->invoices as $invoice)
                                            <tr class="hover:bg-gray-50 transition">
                                                <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                                    #{{ $invoice->invoice_number }}
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-700">
                                                    {{ $invoice->customer_name }}
                                                </td>
                                                <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                                                    ${{ number_format($invoice->total_amount, 2) }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    @if($invoice->status === 'paid')
                                                        <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-800">Paid</span>
                                                    @elseif($invoice->status === 'pending')
                                                        <span class="inline-flex rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-800">Pending</span>
                                                    @else
                                                        <span class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-800">Overdue</span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-600">
                                                    {{ $invoice->created_at->format('M d, Y') }}
                                                </td>
                                                <td class="px-6 py-4 text-right">
                                                    <a href="{{ route('invoice.show', $invoice->id) }}"
                                                       class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                                                        View
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="py-16 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="mb-4 rounded-full bg-gray-100 p-6">
                                        <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-700">No invoices yet</h3>
                                    <p class="mt-2 text-gray-500">Create your first invoice for this branch.</p>
                                    <a href="{{ route('invoice.create', ['branch_id' => $branch->id]) }}"
                                       class="mt-6 rounded-lg bg-indigo-600 px-6 py-3 font-semibold text-white shadow hover:bg-indigo-700 transition">
                                        Create Invoice
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Accountants Section -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                        <div class="border-b border-gray-100 bg-gray-50 px-6 py-4 flex items-center justify-between">
                            <h2 class="text-xl font-bold text-gray-900">Accountants</h2>
                            <button onclick="openModal('create-accountant-modal')"
                                    class="inline-flex items-center rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white hover:bg-green-700 transition">
                                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                </svg>
                                Add
                            </button>
                        </div>

                        <div class="p-6">
                            @if($branch->accountants->count())
                                <div class="space-y-4">
                                    @foreach($branch->accountants as $accountant)
                                        <div class="rounded-lg border border-gray-200 p-4 hover:border-indigo-300 hover:shadow-md transition">
                                            <div class="flex items-start justify-between">
                                                <div class="flex items-center">
                                                    <div class="rounded-full bg-indigo-100 p-3 mr-3">
                                                        <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <h3 class="font-semibold text-gray-900">{{ $accountant->name }}</h3>
                                                        <p class="text-sm text-gray-600">{{ $accountant->email }}</p>
                                                    </div>
                                                </div>
                                                <form action="{{ route('branch.accountant.destroy', [$branch->id, $accountant->id]) }}"
                                                      method="POST"
                                                      onsubmit="return confirm('Remove this accountant?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="text-red-500 hover:text-red-700 transition">
                                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-8">
                                    <div class="mb-4 rounded-full bg-gray-100 p-4 inline-block">
                                        <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                    </div>
                                    <p class="text-gray-500 mb-4">No accountants assigned</p>
                                    <button onclick="openModal('create-accountant-modal')"
                                            class="rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white hover:bg-green-700 transition">
                                        Add First Accountant
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- Create Accountant Modal -->
    <div id="create-accountant-modal"
        class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50"
        onclick="if(event.target === this) closeModal('create-accountant-modal')">
        <div class="w-full max-w-md rounded-xl bg-white p-6 shadow-xl">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="text-xl font-semibold text-gray-800">Add Accountant</h2>
                <button onclick="closeModal('create-accountant-modal')"
                        class="text-gray-400 hover:text-gray-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <p class="mb-4 text-sm text-gray-600">Adding accountant to <span class="font-medium">{{ $branch->name }}</span></p>

            <form action="{{ route('branch.accountant.store', $branch->id) }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="mb-1 block text-sm font-medium text-gray-700">Name</label>
                    <input type="text" name="name" required
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                        placeholder="Enter accountant name">
                </div>

                <div class="mb-6">
                    <label class="mb-1 block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" required
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                        placeholder="Enter email address">
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeModal('create-accountant-modal')"
                        class="rounded-lg bg-gray-200 px-4 py-2 font-medium text-gray-700 hover:bg-gray-300 transition">
                        Cancel
                    </button>
                    <button type="submit"
                        class="rounded-lg bg-green-600 px-4 py-2 font-medium text-white hover:bg-green-700 transition">
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
        }

        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
            document.getElementById(id).classList.remove('flex');
        }
    </script>

@endsection
