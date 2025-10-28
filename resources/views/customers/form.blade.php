@extends('layouts.app')

@section('content')
<div class="">
    <div class="">

        <!-- Page Header -->
        <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
            <div>
                <h5 class="fw-bold mb-1">{{ isset($customer) ? 'Edit Customer' : 'Add New Customer' }}</h5>
                <p class="text-muted mb-0">
                    {{ isset($customer) ? 'Update customer information' : 'Fill in the details to add a new customer' }}
                </p>
            </div>
            <div>
                <a href="{{ route('customer.index') }}" class="btn btn-outline-secondary">
                    <i class="ti ti-arrow-left me-1"></i>Back to Customers
                </a>
            </div>
        </div>
        <!-- End Page Header -->

        <div class="row">
            <div class="col-lg-8 col-md-10 mx-auto">
                <div class="card">
                    <div class="card-body">
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form action="{{ isset($customer) ? route('customer.update', $customer->id) : route('customer.store') }}"
                              method="POST"
                              novalidate>
                            @csrf
                            @if(isset($customer))
                                @method('PUT')
                            @endif

                            <!-- Customer Name -->
                            <div class="mb-3">
                                <label for="name" class="form-label">
                                    Customer Name <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       id="name"
                                       name="name"
                                       placeholder="Enter customer full name"
                                       value="{{ old('name', $customer->name ?? '') }}"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Full name of the customer or company</small>
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    Email Address <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="ti ti-mail"></i>
                                    </span>
                                    <input type="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           id="email"
                                           name="email"
                                           placeholder="customer@example.com"
                                           value="{{ old('email', $customer->email ?? '') }}"
                                           required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="text-muted">Primary email for invoices and communication</small>
                            </div>

                            <!-- Phone -->
                            <div class="mb-3">
                                <label for="phone" class="form-label">
                                    Phone Number <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="ti ti-phone"></i>
                                    </span>
                                    <input type="tel"
                                           class="form-control @error('phone') is-invalid @enderror"
                                           id="phone"
                                           name="phone"
                                           placeholder="+234 xxx xxx xxxx"
                                           value="{{ old('phone', $customer->phone ?? '') }}"
                                           required>
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="text-muted">Contact phone number with country code</small>
                            </div>

                            <!-- Address -->
                            <div class="mb-4">
                                <label for="address" class="form-label">
                                    Address <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text align-items-start pt-2">
                                        <i class="ti ti-map-pin"></i>
                                    </span>
                                    <textarea class="form-control @error('address') is-invalid @enderror"
                                              id="address"
                                              name="address"
                                              rows="3"
                                              placeholder="Enter complete address including street, city, state, and postal code"
                                              required>{{ old('address', $customer->address ?? '') }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <small class="text-muted">Full physical or billing address</small>
                            </div>

                            <!-- Customer Info Preview (Edit Mode) -->
                            @if(isset($customer))
                                <div class="alert alert-info mb-4">
                                    <div class="d-flex align-items-start">
                                        <i class="ti ti-info-circle me-2 fs-5"></i>
                                        <div>
                                            <h6 class="alert-heading mb-1">Customer Information</h6>
                                            <small>
                                                <strong>Created:</strong> {{ $customer->created_at->format('d M, Y') }}<br>
                                                <strong>Last Updated:</strong> {{ $customer->updated_at->format('d M, Y') }}<br>
                                                @if($customer->invoices_count > 0)
                                                    <strong>Total Invoices:</strong> {{ $customer->invoices_count }}
                                                @endif
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Form Actions -->
                            <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                                <a href="{{ route('customer.index') }}" class="btn btn-secondary">
                                    <i class="ti ti-x me-1"></i>Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-device-floppy me-1"></i>
                                    {{ isset($customer) ? 'Update Customer' : 'Save Customer' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Additional Tips Card -->
                <div class="card mt-3">
                    <div class="card-body">
                        <h6 class="card-title mb-3">
                            <i class="ti ti-bulb text-warning me-2"></i>Tips
                        </h6>
                        <ul class="mb-0 text-muted">
                            <li class="mb-2">
                                <strong>Email:</strong> Make sure the email is valid as it will be used for sending invoices
                            </li>
                            <li class="mb-2">
                                <strong>Phone:</strong> Include country code for international customers
                            </li>
                            <li>
                                <strong>Address:</strong> Complete address helps with shipping and billing
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    // Form validation feedback
    (function () {
        'use strict'
        const forms = document.querySelectorAll('form[novalidate]')
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
    })()

    // Auto-format phone number (optional enhancement)
    const phoneInput = document.getElementById('phone');
    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            // Add basic formatting if needed
            e.target.value = value;
        });
    }

    // Email validation
    const emailInput = document.getElementById('email');
    if (emailInput) {
        emailInput.addEventListener('blur', function() {
            const email = this.value;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (email && !emailRegex.test(email)) {
                this.classList.add('is-invalid');
                if (!this.nextElementSibling || !this.nextElementSibling.classList.contains('invalid-feedback')) {
                    const feedback = document.createElement('div');
                    feedback.className = 'invalid-feedback';
                    feedback.textContent = 'Please enter a valid email address';
                    this.parentNode.appendChild(feedback);
                }
            } else {
                this.classList.remove('is-invalid');
                const feedback = this.parentNode.querySelector('.invalid-feedback');
                if (feedback && feedback.textContent === 'Please enter a valid email address') {
                    feedback.remove();
                }
            }
        });
    }
</script>
@endsection
