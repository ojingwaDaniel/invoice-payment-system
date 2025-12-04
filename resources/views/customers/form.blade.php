@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">

            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">
                            {{ isset($customer) ? 'Edit Customer' : 'Add New Customer' }}
                        </h1>
                        <p class="mt-2 text-gray-600">
                            {{ isset($customer) ? 'Update customer information' : 'Fill in the details to add a new customer' }}
                        </p>
                    </div>
                    <div>
                        <a href="{{ route('customer.index') }}"
                            class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                            <i class="fas fa-arrow-left"></i>
                            Back to Customers
                        </a>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
                <!-- Main Form -->
                <div class="lg:col-span-2">
                    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                        <!-- Alerts -->
                        @if (session('error'))
                            <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <i class="fas fa-exclamation-circle mr-2 text-red-400"></i>
                                        <p class="text-sm text-red-700">{{ session('error') }}</p>
                                    </div>
                                    <button type="button" class="text-red-600 hover:text-red-800">
                                        <i class="fas fa-times text-sm"></i>
                                    </button>
                                </div>
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="mb-2 flex items-center">
                                            <i class="fas fa-exclamation-circle mr-2 text-red-400"></i>
                                            <p class="text-sm font-medium text-red-700">Please fix the following errors:</p>
                                        </div>
                                        <ul class="list-inside list-disc space-y-1 text-sm text-red-600">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <button type="button" class="ml-4 text-red-600 hover:text-red-800">
                                        <i class="fas fa-times text-sm"></i>
                                    </button>
                                </div>
                            </div>
                        @endif

                        <form
                            action="{{ isset($customer) ? route('customer.update', $customer->id) : route('customer.store') }}"
                            method="POST" novalidate class="space-y-6">
                            @csrf
                            @if (isset($customer))
                                @method('PUT')
                            @endif

                            <!-- Customer Name -->
                            <div>
                                <label for="name" class="mb-2 block text-sm font-medium text-gray-700">
                                    Customer Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text"
                                    class="@error('name') border-red-300 @enderror w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500"
                                    id="name" name="name" placeholder="Enter customer full name"
                                    value="{{ old('name', $customer->name ?? '') }}" required>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">Full name of the customer or company</p>
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="mb-2 block text-sm font-medium text-gray-700">
                                    Email Address <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <i class="fas fa-envelope text-gray-400"></i>
                                    </div>
                                    <input type="email"
                                        class="@error('email') border-red-300 @enderror w-full rounded-lg border border-gray-300 py-2.5 pl-10 pr-4 text-sm focus:border-blue-500 focus:ring-blue-500"
                                        id="email" name="email" placeholder="customer@example.com"
                                        value="{{ old('email', $customer->email ?? '') }}" required>
                                </div>
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">Primary email for invoices and communication</p>
                            </div>

                            <!-- Phone -->
                            <div>
                                <label for="phone" class="mb-2 block text-sm font-medium text-gray-700">
                                    Phone Number <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                        <i class="fas fa-phone text-gray-400"></i>
                                    </div>
                                    <input type="tel"
                                        class="@error('phone') border-red-300 @enderror w-full rounded-lg border border-gray-300 py-2.5 pl-10 pr-4 text-sm focus:border-blue-500 focus:ring-blue-500"
                                        id="phone" name="phone" placeholder="+234 xxx xxx xxxx"
                                        value="{{ old('phone', $customer->phone ?? '') }}" required>
                                </div>
                                @error('phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">Contact phone number with country code</p>
                            </div>

                            <!-- Address -->
                            <div>
                                <label for="address" class="mb-2 block text-sm font-medium text-gray-700">
                                    Address <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="pointer-events-none absolute left-3 top-3">
                                        <i class="fas fa-map-marker-alt text-gray-400"></i>
                                    </div>
                                    <textarea
                                        class="@error('address') border-red-300 @enderror w-full rounded-lg border border-gray-300 py-2.5 pl-10 pr-4 text-sm focus:border-blue-500 focus:ring-blue-500"
                                        id="address" name="address" rows="3"
                                        placeholder="Enter complete address including street, city, state, and postal code" required>{{ old('address', $customer->address ?? '') }}</textarea>
                                </div>
                                @error('address')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">Full physical or billing address</p>
                            </div>

                            <!-- Customer Info Preview (Edit Mode) -->
                            @if (isset($customer))
                                <div class="rounded-lg border border-blue-200 bg-blue-50 p-4">
                                    <div class="flex items-start">
                                        <i class="fas fa-info-circle mr-3 mt-0.5 text-blue-400"></i>
                                        <div class="flex-1">
                                            <h4 class="mb-2 text-sm font-medium text-blue-900">Customer Information</h4>
                                            <div class="grid grid-cols-1 gap-2 text-xs text-blue-800 sm:grid-cols-2">
                                                <div>
                                                    <span class="font-medium">Created:</span>
                                                    {{ $customer->created_at->format('d M, Y') }}
                                                </div>
                                                <div>
                                                    <span class="font-medium">Last Updated:</span>
                                                    {{ $customer->updated_at->format('d M, Y') }}
                                                </div>
                                                @if ($customer->invoices_count > 0)
                                                    <div class="sm:col-span-2">
                                                        <span class="font-medium">Total Invoices:</span>
                                                        {{ $customer->invoices_count }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Form Actions -->
                            <div
                                class="flex flex-col-reverse gap-4 border-t border-gray-200 pt-6 sm:flex-row sm:items-center sm:justify-between">
                                <a href="{{ route('customer.index') }}"
                                    class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-6 py-2.5 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                                    <i class="fas fa-times"></i>
                                    Cancel
                                </a>
                                <button type="submit"
                                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-6 py-2.5 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    <i class="fas fa-save"></i>
                                    {{ isset($customer) ? 'Update Customer' : 'Save Customer' }}
                                </button>
                            </div>
                            @if (auth()->user()->role === 'admin')
                                <div>
                                    <label for="branch_id" class="mb-2 block text-sm font-medium text-gray-700">
                                        Select Branch <span class="text-red-500">*</span>
                                    </label>

                                    <select id="branch_id" name="branch_id"
                                        class="@error('branch_id') border-red-300 @enderror w-full rounded-lg border border-gray-300 px-4 py-2.5 text-sm"
                                        required>
                                        <option value="">-- Select Branch --</option>
                                        @foreach (\App\Models\Branch::where('company_id', auth()->user()->company_id)->get() as $branch)
                                            <option value="{{ $branch->id }}"
                                                {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                                {{ $branch->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('branch_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endif

                        </form>
                    </div>
                </div>

                <!-- Tips Sidebar -->
                <div class="lg:col-span-1">
                    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                        <div class="mb-4 flex items-center">
                            <div class="rounded-lg bg-yellow-100 p-2">
                                <i class="fas fa-lightbulb text-yellow-600"></i>
                            </div>
                            <h3 class="ml-3 text-lg font-medium text-gray-900">Tips</h3>
                        </div>

                        <div class="space-y-4">
                            <div class="flex items-start">
                                <i class="fas fa-envelope mr-3 mt-1 text-sm text-blue-500"></i>
                                <div>
                                    <h4 class="mb-1 text-sm font-medium text-gray-900">Email</h4>
                                    <p class="text-xs text-gray-600">Make sure the email is valid as it will be used for
                                        sending invoices</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <i class="fas fa-phone mr-3 mt-1 text-sm text-green-500"></i>
                                <div>
                                    <h4 class="mb-1 text-sm font-medium text-gray-900">Phone</h4>
                                    <p class="text-xs text-gray-600">Include country code for international customers</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <i class="fas fa-map-marker-alt mr-3 mt-1 text-sm text-purple-500"></i>
                                <div>
                                    <h4 class="mb-1 text-sm font-medium text-gray-900">Address</h4>
                                    <p class="text-xs text-gray-600">Complete address helps with shipping and billing</p>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Stats (Edit Mode) -->
                        @if (isset($customer) && $customer->invoices_count > 0)
                            <div class="mt-6 border-t border-gray-200 pt-6">
                                <h4 class="mb-3 text-sm font-medium text-gray-900">Quick Stats</h4>
                                <div class="space-y-2">
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs text-gray-600">Total Invoices</span>
                                        <span
                                            class="text-sm font-medium text-gray-900">{{ $customer->invoices_count }}</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-xs text-gray-600">Member Since</span>
                                        <span
                                            class="text-sm font-medium text-gray-900">{{ $customer->created_at->format('M Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Additional Help Card -->
                    <div class="mt-4 rounded-xl border border-blue-200 bg-gradient-to-r from-blue-50 to-cyan-50 p-6">
                        <div class="mb-3 flex items-center">
                            <i class="fas fa-question-circle mr-2 text-blue-500"></i>
                            <h4 class="text-sm font-medium text-blue-900">Need Help?</h4>
                        </div>
                        <p class="mb-3 text-xs text-blue-700">
                            Ensure all required fields (marked with *) are filled correctly for better customer management.
                        </p>
                        <a href="#"
                            class="inline-flex items-center text-xs font-medium text-blue-600 hover:text-blue-800">
                            View documentation
                            <i class="fas fa-arrow-right ml-1 text-xs"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Form validation feedback
        (function() {
            'use strict'
            const forms = document.querySelectorAll('form[novalidate]')
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    // Add validation styles to all fields
                    const fields = form.querySelectorAll('input, textarea, select');
                    fields.forEach(field => {
                        if (!field.checkValidity()) {
                            field.classList.add('border-red-300');
                        } else {
                            field.classList.remove('border-red-300');
                        }
                    });
                }, false)
            })
        })()

        // Real-time validation
        document.addEventListener('DOMContentLoaded', function() {
            // Email validation
            const emailInput = document.getElementById('email');
            if (emailInput) {
                emailInput.addEventListener('blur', function() {
                    const email = this.value;
                    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                    if (email && !emailRegex.test(email)) {
                        this.classList.add('border-red-300');
                        // Remove any existing error message
                        let existingError = this.parentNode.nextElementSibling;
                        if (existingError && existingError.classList.contains('text-red-600')) {
                            existingError.remove();
                        }
                        // Add new error message
                        const errorDiv = document.createElement('p');
                        errorDiv.className = 'mt-1 text-sm text-red-600';
                        errorDiv.textContent = 'Please enter a valid email address';
                        this.parentNode.parentNode.appendChild(errorDiv);
                    } else {
                        this.classList.remove('border-red-300');
                        // Remove error message if exists
                        let existingError = this.parentNode.nextElementSibling;
                        if (existingError && existingError.classList.contains('text-red-600')) {
                            existingError.remove();
                        }
                    }
                });
            }

            // Phone number formatting (optional)
            const phoneInput = document.getElementById('phone');
            if (phoneInput) {
                phoneInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    // You can add phone formatting logic here if needed
                    e.target.value = value;
                });
            }

            // Real-time field validation
            const fields = document.querySelectorAll('input[required], textarea[required]');
            fields.forEach(field => {
                field.addEventListener('blur', function() {
                    if (!this.value.trim()) {
                        this.classList.add('border-red-300');
                    } else {
                        this.classList.remove('border-red-300');
                    }
                });
            });
        });

        // Auto-save draft (optional feature)
        let saveTimeout;

        function autoSaveDraft() {
            clearTimeout(saveTimeout);
            saveTimeout = setTimeout(() => {
                // Implement auto-save logic here
                console.log('Auto-saving draft...');
            }, 2000);
        }

        // Add input listeners for auto-save
        const formFields = document.querySelectorAll('input, textarea');
        formFields.forEach(field => {
            field.addEventListener('input', autoSaveDraft);
        });
    </script>
@endsection
