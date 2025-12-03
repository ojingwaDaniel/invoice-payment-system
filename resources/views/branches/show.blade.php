@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 px-4 py-8">
        <div class="mx-auto max-w-7xl">

            <!-- Enhanced Back Button -->
            <div class="mb-8">
                <a href="{{ route('branch.index') }}"
                    class="group inline-flex items-center rounded-full bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-sm ring-1 ring-gray-200 transition-all duration-300 hover:bg-gray-50 hover:shadow-md hover:ring-gray-300">
                    <svg class="mr-2.5 h-4 w-4 transform transition-transform group-hover:-translate-x-0.5" fill="none"
                        stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                    </svg>
                    Back to All Branches
                </a>
            </div>

            <!-- Premium Branch Header -->
            <div
                class="relative mb-10 overflow-hidden rounded-3xl bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 p-10 shadow-2xl">
                <div
                    class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiMyMDI0MzEiIGZpbGwtb3BhY2l0eT0iMC4xIj48cGF0aCBkPSJNMzYgMzRjMC0yLjIgMS44LTQgNC00czQgMS44IDQgNC0xLjggNC00IDQtNC0xLjgtNC00eiIvPjwvZz48L2c+PC9zdmc+')] opacity-20">
                </div>

                <div class="relative flex flex-col justify-between lg:flex-row lg:items-start">
                    <div class="mb-8 lg:mb-0">
                        <div class="mb-3 inline-flex items-center rounded-full bg-white/10 px-4 py-1.5 backdrop-blur-sm">
                            <span class="mr-2 h-2 w-2 animate-pulse rounded-full bg-emerald-400"></span>
                            <span class="text-sm font-medium text-slate-300">Branch Active</span>
                        </div>

                        <h1 class="mb-4 text-5xl font-bold tracking-tight text-white">{{ $branch->name }}</h1>

                        <div class="mb-6 flex items-center text-slate-300">
                            <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                            </svg>
                            <p class="text-lg text-slate-300">{{ $branch->address }}</p>
                        </div>

                        <div class="flex flex-wrap gap-6">
                            @if ($branch->manager)
                                <div class="flex items-center rounded-lg bg-white/5 px-4 py-2.5 backdrop-blur-sm">
                                    <div class="mr-3 rounded-full bg-white/10 p-2">
                                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor"
                                            stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-medium text-slate-400">Branch Manager</p>
                                        <p class="font-medium text-white">{{ $branch->manager }}</p>
                                    </div>
                                </div>
                            @endif

                            @if ($branch->phone)
                                <div class="flex items-center rounded-lg bg-white/5 px-4 py-2.5 backdrop-blur-sm">
                                    <div class="mr-3 rounded-full bg-white/10 p-2">
                                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor"
                                            stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs font-medium text-slate-400">Contact</p>
                                        <p class="font-medium text-white">{{ $branch->phone }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <a href="{{ route('branch.edit', $branch->id) }}"
                            class="group inline-flex items-center rounded-xl bg-white/10 px-6 py-3.5 font-semibold text-white backdrop-blur-sm transition-all duration-300 hover:bg-white/20 hover:shadow-lg">
                            <svg class="mr-2.5 h-5 w-5 transition-transform group-hover:rotate-12" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>
                            Edit Branch
                        </a>
                    </div>
                </div>
            </div>

            <!-- Enhanced Stats Cards -->
            <div class="mb-10 grid grid-cols-1 gap-6 md:grid-cols-3">
                <div
                    class="group relative overflow-hidden rounded-2xl bg-white p-6 shadow-lg transition-all duration-300 hover:scale-[1.02] hover:shadow-2xl">
                    <div
                        class="absolute -right-6 -top-6 h-24 w-24 rounded-full bg-gradient-to-br from-blue-500/10 to-transparent">
                    </div>
                    <div class="relative flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Invoices</p>
                            <p class="mt-2 text-4xl font-bold tracking-tight text-gray-900">{{ $branch->invoices->count() }}
                            </p>
                            <div class="mt-2 flex items-center">
                                <svg class="mr-1 h-4 w-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span
                                    class="text-sm text-green-600">{{ $branch->invoices->where('status', 'paid')->count() }}
                                    paid</span>
                            </div>
                        </div>
                        <div class="rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 p-4 shadow-lg">
                            <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div
                    class="group relative overflow-hidden rounded-2xl bg-white p-6 shadow-lg transition-all duration-300 hover:scale-[1.02] hover:shadow-2xl">
                    <div
                        class="absolute -right-6 -top-6 h-24 w-24 rounded-full bg-gradient-to-br from-emerald-500/10 to-transparent">
                    </div>
                    <div class="relative flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Accountants</p>
                            <p class="mt-2 text-4xl font-bold tracking-tight text-gray-900">
                                {{ $branch->accountants->count() }}</p>
                            <p class="mt-2 text-sm text-gray-500">Managing invoices</p>
                        </div>
                        <div class="rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 p-4 shadow-lg">
                            <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div
                    class="group relative overflow-hidden rounded-2xl bg-white p-6 shadow-lg transition-all duration-300 hover:scale-[1.02] hover:shadow-2xl">
                    <div
                        class="absolute -right-6 -top-6 h-24 w-24 rounded-full bg-gradient-to-br from-purple-500/10 to-transparent">
                    </div>
                    <div class="relative flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Branch Created</p>
                            <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900">
                                {{ $branch->created_at->format('M d, Y') }}</p>
                            <p class="mt-2 text-sm text-gray-500">{{ $branch->created_at->diffForHumans() }}</p>
                        </div>
                        <div class="rounded-xl bg-gradient-to-br from-purple-500 to-purple-600 p-4 shadow-lg">
                            <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">

                <div class="lg:col-span-2">
                    <div class="overflow-hidden rounded-2xl bg-white shadow-2xl">
                        <div class="border-b border-gray-100 bg-gradient-to-r from-white to-gray-50 px-8 py-6">
                            <div class="flex flex-col justify-between sm:flex-row sm:items-center">
                                <div>
                                    <h2 class="text-2xl font-bold tracking-tight text-gray-900">Invoice History</h2>
                                    <p class="mt-1 text-sm text-gray-600">All invoices created for this branch</p>
                                </div>
                                <a href="{{ route('invoice.create', ['branch_id' => $branch->id]) }}"
                                    class="group mt-4 inline-flex items-center justify-center rounded-xl bg-gradient-to-r from-indigo-600 to-indigo-700 px-5 py-3 font-semibold text-white shadow-lg transition-all duration-300 hover:from-indigo-700 hover:to-indigo-800 hover:shadow-xl sm:mt-0">
                                    <svg class="mr-3 h-5 w-5 transition-transform group-hover:rotate-90" fill="none"
                                        stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Create New Invoice
                                </a>
                            </div>
                        </div>

                        @if ($branch->invoices->count())
                            <div class="overflow-x-auto">
                                <table class="min-w-full">
                                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                                        <tr class="text-left text-sm font-semibold text-gray-700">
                                            <th class="px-8 py-4">Invoice #</th>
                                            <th class="px-8 py-4">Customer</th>
                                            <th class="px-8 py-4">Created By</th>
                                            <th class="px-8 py-4">Amount</th>
                                            <th class="px-8 py-4">Status</th>
                                            <th class="px-8 py-4">Due Date</th>
                                            <th class="px-8 py-4 text-right">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @foreach ($branch->invoices as $invoice)
                                            <tr class="group transition-all duration-300 hover:bg-gray-50/80">
                                                <td class="px-8 py-5">
                                                    <div class="flex items-center">
                                                        <div class="mr-3 rounded-lg bg-indigo-50 p-2">
                                                            <svg class="h-5 w-5 text-indigo-600" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                            </svg>
                                                        </div>
                                                        <div>
                                                            <div class="font-semibold text-gray-900">
                                                                #{{ $invoice->invoice_number }}</div>
                                                            <div class="text-xs text-gray-500">
                                                                {{ $invoice->created_at->format('M d, Y') }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-8 py-5">
                                                    <div class="font-medium text-gray-900">
                                                        {{ $invoice->customer->name ?? 'N/A' }}</div>
                                                    <div class="max-w-xs truncate text-sm text-gray-500">
                                                        {{ $invoice->customer->email ?? 'No email' }}
                                                    </div>
                                                </td>
                                                <td class="px-8 py-5">
                                                    @if ($invoice->creator)
                                                        <div class="flex items-center">
                                                            <div
                                                                class="mr-3 flex h-8 w-8 items-center justify-center rounded-full bg-gradient-to-br from-emerald-100 to-emerald-50 shadow-sm">
                                                                @if ($invoice->creator->profile_photo_path)
                                                                    <img src="{{ asset('storage/' . $invoice->creator->profile_photo_path) }}"
                                                                        alt="{{ $invoice->creator->name }}"
                                                                        class="h-full w-full rounded-full object-cover">
                                                                @else
                                                                    <span class="text-sm font-semibold text-emerald-700">
                                                                        {{ substr($invoice->creator->name, 0, 1) }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                            <div>
                                                                <div class="font-medium text-gray-900">
                                                                    {{ $invoice->creator->name }}</div>
                                                                <div class="text-xs text-gray-500">Accountant</div>
                                                            </div>
                                                        </div>
                                                    @elseif ($invoice->user)
                                                        <div class="flex items-center">
                                                            <div
                                                                class="mr-3 flex h-8 w-8 items-center justify-center rounded-full bg-gradient-to-br from-blue-100 to-blue-50 shadow-sm">
                                                                @if ($invoice->user->profile_photo_path)
                                                                    <img src="{{ asset('storage/' . $invoice->user->profile_photo_path) }}"
                                                                        alt="{{ $invoice->user->name }}"
                                                                        class="h-full w-full rounded-full object-cover">
                                                                @else
                                                                    <span class="text-sm font-semibold text-blue-700">
                                                                        {{ substr($invoice->user->name, 0, 1) }}
                                                                    </span>
                                                                @endif
                                                            </div>
                                                            <div>
                                                                <div class="font-medium text-gray-900">
                                                                    {{ $invoice->user->name }}</div>
                                                                <div class="text-xs text-gray-500">User</div>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <span class="text-sm text-gray-400">Unknown</span>
                                                    @endif
                                                </td>
                                                <td class="px-8 py-5">
                                                    <div class="text-lg font-bold text-gray-900">
                                                        {{ $invoice->currency }}
                                                        {{ number_format($invoice->total_amount, 2) }}
                                                    </div>
                                                    @if ($invoice->paid > 0)
                                                        <div class="text-xs text-green-600">
                                                            Paid: {{ $invoice->currency }}
                                                            {{ number_format($invoice->paid, 2) }}
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="px-8 py-5">
                                                    @if ($invoice->status === 'paid')
                                                        <span
                                                            class="inline-flex items-center rounded-full bg-gradient-to-r from-emerald-50 to-emerald-100 px-3 py-1.5 text-xs font-semibold text-emerald-800">
                                                            <span
                                                                class="mr-1.5 h-2 w-2 rounded-full bg-emerald-500"></span>
                                                            Paid
                                                        </span>
                                                    @elseif($invoice->status === 'pending')
                                                        @if ($invoice->due_date && $invoice->due_date->isPast())
                                                            <span
                                                                class="inline-flex items-center rounded-full bg-gradient-to-r from-rose-50 to-rose-100 px-3 py-1.5 text-xs font-semibold text-rose-800">
                                                                <span
                                                                    class="mr-1.5 h-2 w-2 rounded-full bg-rose-500"></span>
                                                                Overdue
                                                            </span>
                                                        @else
                                                            <span
                                                                class="inline-flex items-center rounded-full bg-gradient-to-r from-amber-50 to-amber-100 px-3 py-1.5 text-xs font-semibold text-amber-800">
                                                                <span
                                                                    class="mr-1.5 h-2 w-2 rounded-full bg-amber-500"></span>
                                                                Pending
                                                            </span>
                                                        @endif
                                                    @else
                                                        <span
                                                            class="inline-flex items-center rounded-full bg-gradient-to-r from-gray-50 to-gray-100 px-3 py-1.5 text-xs font-semibold text-gray-800">
                                                            <span class="mr-1.5 h-2 w-2 rounded-full bg-gray-500"></span>
                                                            {{ ucfirst($invoice->status) }}
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="px-8 py-5">
                                                    @if ($invoice->due_date)
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $invoice->due_date->format('M d, Y') }}</div>
                                                        <div class="text-xs text-gray-500">
                                                            @if ($invoice->due_date->isPast())
                                                                <span class="text-rose-600">Overdue</span>
                                                            @else
                                                                {{ $invoice->due_date->diffForHumans() }}
                                                            @endif
                                                        </div>
                                                    @else
                                                        <span class="text-sm text-gray-400">No due date</span>
                                                    @endif
                                                </td>
                                                <td class="px-8 py-5 text-right">
                                                    <div class="flex justify-end space-x-2">
                                                        <a href="{{ route('invoice.show', $invoice->id) }}"
                                                            class="inline-flex items-center rounded-lg bg-gray-100 px-3.5 py-2 text-sm font-medium text-gray-700 transition-all duration-300 hover:bg-gray-200 hover:shadow-md">
                                                            <svg class="mr-2 h-4 w-4" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                            </svg>
                                                            View
                                                        </a>
                                                        @if ($invoice->status !== 'paid')
                                                            <a href="{{ route('invoice.edit', $invoice->id) }}"
                                                                class="inline-flex items-center rounded-lg bg-blue-50 px-3.5 py-2 text-sm font-medium text-blue-700 transition-all duration-300 hover:bg-blue-100 hover:shadow-md">
                                                                <svg class="mr-2 h-4 w-4" fill="none"
                                                                    stroke="currentColor" stroke-width="2"
                                                                    viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                                </svg>
                                                                Edit
                                                            </a>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="border-t border-gray-100 bg-gray-50 px-8 py-4">
                                <div class="flex flex-col justify-between sm:flex-row sm:items-center">
                                    <div class="mb-2 text-sm text-gray-600 sm:mb-0">
                                        Showing {{ $branch->invoices->count() }} invoices
                                    </div>
                                    <div class="flex items-center space-x-6">
                                        <div class="flex items-center space-x-2">
                                            <svg class="h-4 w-4 text-green-500" fill="none" stroke="currentColor"
                                                stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span class="text-sm text-gray-700">
                                                Paid: {{ $branch->invoices->where('status', 'paid')->count() }}
                                            </span>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <svg class="h-4 w-4 text-amber-500" fill="none" stroke="currentColor"
                                                stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span class="text-sm text-gray-700">
                                                Pending: {{ $branch->invoices->where('status', 'pending')->count() }}
                                            </span>
                                        </div>
                                        <div class="text-sm font-semibold text-gray-900">
                                            Total: {{ $branch->invoices->first()->currency ?? 'USD' }}
                                            {{ number_format($branch->invoices->sum('total_amount'), 2) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="py-20 text-center">
                                <div
                                    class="mx-auto mb-6 flex h-24 w-24 items-center justify-center rounded-full bg-gradient-to-br from-gray-100 to-gray-50 shadow-lg">
                                    <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                        stroke-width="1.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <h3 class="mb-2 text-xl font-semibold text-gray-900">No invoices yet</h3>
                                <p class="mb-6 text-gray-500">Start by creating your first invoice for this branch</p>
                                <a href="{{ route('invoice.create', ['branch_id' => $branch->id]) }}"
                                    class="inline-flex items-center rounded-xl bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-3.5 font-semibold text-white shadow-lg transition-all duration-300 hover:from-indigo-700 hover:to-indigo-800 hover:shadow-xl">
                                    Create First Invoice
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Enhanced Accountants Section -->
                <div class="lg:col-span-1">
                    <div class="sticky top-8 overflow-hidden rounded-3xl border border-gray-100 bg-white shadow-xl">

                        <!-- Header -->
                        <div class="border-b border-gray-100 bg-gradient-to-b from-white to-gray-50 px-8 py-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h2 class="text-xl font-bold tracking-tight text-gray-900">Accountants</h2>
                                    <p class="mt-1 text-sm text-gray-500">Manage financial operators for this branch</p>
                                </div>

                                <button onclick="openModal('create-accountant-modal')"
                                    class="flex items-center gap-2 rounded-xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow-md transition hover:bg-emerald-700">
                                    <span class="text-lg leading-none">+</span> Add
                                </button>
                            </div>
                        </div>

                        <!-- Body -->
                        <div class="px-8 py-6">
                            @if ($branch->accountants->count())
                                <div class="space-y-5">
                                    @foreach ($branch->accountants as $accountant)
                                        <div
                                            class="group relative rounded-2xl border border-gray-200 bg-white p-5 shadow-sm transition hover:shadow-lg">
                                            <div class="flex items-center gap-4">

                                                <!-- Avatar -->
                                                <div
                                                    class="flex h-14 w-14 items-center justify-center rounded-full bg-emerald-600 text-lg font-semibold text-white shadow">
                                                    {{ strtoupper(substr($accountant->name, 0, 1)) }}
                                                </div>

                                                <!-- Info -->
                                                <div class="flex-1">
                                                    <h3 class="text-sm font-semibold text-gray-900">
                                                        {{ $accountant->name }}
                                                    </h3>
                                                    <p class="text-xs text-gray-500">{{ $accountant->email }}</p>

                                                    <div class="mt-2">
                                                        <span
                                                            class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2 py-0.5 text-xs font-medium text-emerald-700">
                                                            <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                                                            Active
                                                        </span>
                                                    </div>
                                                </div>

                                                <!-- Delete -->
                                                <form
                                                    action="{{ route('branch.accountant.destroy', [$branch->id, $accountant->id]) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Remove {{ $accountant->name }} from this branch?');">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                        class="rounded-full p-2 text-gray-400 transition hover:bg-red-50 hover:text-red-600">
                                                        <svg class="h-4 w-4" fill="none" stroke="currentColor"
                                                            stroke-width="2.2" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </button>
                                                </form>

                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <!-- Empty State -->
                                <div class="py-10 text-center">
                                    <div
                                        class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-gray-100">
                                        <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor"
                                            stroke-width="1.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                    </div>

                                    <h3 class="mt-4 text-lg font-semibold text-gray-900">No accountants assigned</h3>
                                    <p class="text-sm text-gray-500">Add accountants to manage branch invoices</p>

                                    <button onclick="openModal('create-accountant-modal')"
                                        class="mt-6 inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-6 py-3 font-semibold text-white shadow-md transition hover:bg-emerald-700">
                                        + Add First Accountant
                                    </button>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Enhanced Create Accountant Modal -->
    <div id="create-accountant-modal"
        class="fixed inset-0 z-50 hidden items-center justify-center bg-black/70 backdrop-blur-sm"
        onclick="if(event.target === this) closeModal('create-accountant-modal')">
        <div class="relative w-full max-w-lg scale-95 transform opacity-0 transition-all duration-300" id="modal-content">
            <div class="relative overflow-hidden rounded-2xl bg-white shadow-2xl">
                <!-- Modal Header -->
                <div class="border-b border-gray-200 bg-gradient-to-r from-emerald-600 to-emerald-700 px-8 py-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="mr-4 rounded-xl bg-white/20 p-2.5 backdrop-blur-sm">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-white">Add Accountant</h2>
                                <p class="text-sm text-emerald-100">Add to {{ $branch->name }}</p>
                            </div>
                        </div>
                        <button onclick="closeModal('create-accountant-modal')"
                            class="rounded-lg p-2 text-white/80 transition hover:bg-white/10 hover:text-white">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <form action="{{ route('branch.accountant.store', $branch->id) }}" method="POST" class="px-8 py-8">
                    @csrf

                    <div class="mb-8">
                        <div class="mb-1 flex items-center justify-between">
                            <label class="text-sm font-medium text-gray-700">Full Name</label>
                            <span class="text-xs text-gray-500">Required</span>
                        </div>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <input type="text" name="name" required
                                class="w-full rounded-xl border border-gray-300 bg-gray-50 py-3.5 pl-12 pr-4 font-medium text-gray-900 shadow-sm transition-all duration-300 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 focus:ring-offset-2"
                                placeholder="Enter accountant name">
                        </div>
                    </div>

                    <div class="mb-8">
                        <div class="mb-1 flex items-center justify-between">
                            <label class="text-sm font-medium text-gray-700">Email Address</label>
                            <span class="text-xs text-gray-500">Required</span>
                        </div>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <input type="email" name="email" required
                                class="w-full rounded-xl border border-gray-300 bg-gray-50 py-3.5 pl-12 pr-4 font-medium text-gray-900 shadow-sm transition-all duration-300 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 focus:ring-offset-2"
                                placeholder="Enter email address">
                        </div>
                    </div>

                    <div class="flex items-center justify-end space-x-4 border-t border-gray-200 pt-8">
                        <button type="button" onclick="closeModal('create-accountant-modal')"
                            class="rounded-xl border border-gray-300 bg-white px-6 py-3 font-medium text-gray-700 shadow-sm transition-all duration-300 hover:bg-gray-50 hover:shadow-md">
                            Cancel
                        </button>
                        <button type="submit"
                            class="rounded-xl bg-gradient-to-r from-emerald-600 to-emerald-700 px-8 py-3.5 font-semibold text-white shadow-lg transition-all duration-300 hover:from-emerald-700 hover:to-emerald-800 hover:shadow-xl">
                            Add Accountant
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openModal(id) {
            const modal = document.getElementById(id);
            const content = document.getElementById('modal-content');
            modal.classList.remove('hidden');
            modal.classList.add('flex');

            setTimeout(() => {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeModal(id) {
            const modal = document.getElementById(id);
            const content = document.getElementById('modal-content');
            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');

            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 200);
        }

        // Close modal with Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeModal('create-accountant-modal');
            }
        });
    </script>
@endsection
