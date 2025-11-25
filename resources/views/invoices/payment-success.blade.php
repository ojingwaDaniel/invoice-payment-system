<!DOCTYPE html>
<html>
<head>
    <title>Payment Successful</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.5);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }
        
        @keyframes checkmark {
            0% {
                stroke-dashoffset: 100;
            }
            100% {
                stroke-dashoffset: 0;
            }
        }
        
        .animate-slide-up {
            animation: slideUp 0.6s ease-out forwards;
        }
        
        .animate-scale-in {
            animation: scaleIn 0.5s ease-out forwards;
        }
        
        .checkmark-circle {
            stroke-dasharray: 166;
            stroke-dashoffset: 166;
            animation: checkmark 0.6s 0.3s ease-out forwards;
        }
        
        .checkmark-check {
            stroke-dasharray: 48;
            stroke-dashoffset: 48;
            animation: checkmark 0.3s 0.8s ease-out forwards;
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .detail-card {
            transition: all 0.3s ease;
        }
        
        .detail-card:hover {
            transform: translateX(4px);
            background: #f8fafc;
        }
    </style>
</head>

<body class="min-h-screen gradient-bg flex items-center justify-center p-4">

<div class="max-w-2xl w-full mx-auto">
    
    <!-- Main Card -->
    <div class="glass-effect shadow-2xl rounded-3xl p-8 md:p-12 text-center animate-slide-up">
        
        <!-- Success Icon with Animation -->
        <div class="flex justify-center mb-6 animate-scale-in">
            <svg width="120" height="120" viewBox="0 0 120 120">
                <!-- Outer Circle -->
                <circle cx="60" cy="60" r="54" fill="#10b981" opacity="0.1"/>
                
                <!-- Animated Circle -->
                <circle 
                    class="checkmark-circle"
                    cx="60" 
                    cy="60" 
                    r="52" 
                    fill="none" 
                    stroke="#10b981" 
                    stroke-width="4"
                />
                
                <!-- Animated Checkmark -->
                <path 
                    class="checkmark-check"
                    d="M 38 60 L 52 74 L 82 44" 
                    fill="none" 
                    stroke="#10b981" 
                    stroke-width="5" 
                    stroke-linecap="round" 
                    stroke-linejoin="round"
                />
            </svg>
        </div>

        <!-- Success Message -->
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-3">
            Payment Successful!
        </h1>
        
        <p class="text-lg text-gray-600 mb-8">
            Thank you, <span class="font-semibold text-gray-900">{{ $invoice->customer->name }}</span>! 
            <br class="hidden sm:block"/>
            Your payment has been processed successfully.
        </p>

        <!-- Divider -->
        <div class="w-20 h-1 bg-gradient-to-r from-green-400 to-emerald-500 rounded-full mx-auto mb-8"></div>

        <!-- Payment Details -->
        <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl p-6 md:p-8 mb-8 text-left">
            
            <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-6">
                Payment Details
            </h2>
            
            <div class="space-y-4">
                <!-- Invoice Number -->
                <div class="detail-card flex justify-between items-center p-4 rounded-xl border border-gray-200">
                    <span class="text-gray-600 font-medium">Invoice Number</span>
                    <span class="text-gray-900 font-bold">#{{ $invoice->invoice_number }}</span>
                </div>
                
                <!-- Amount Paid -->
                <div class="detail-card flex justify-between items-center p-4 rounded-xl border border-gray-200">
                    <span class="text-gray-600 font-medium">Amount Paid</span>
                    <span class="text-2xl font-bold text-green-600">
                        ₦{{ number_format($invoice->total_amount, 2) }}
                    </span>
                </div>
                
                <!-- Payment Reference -->
                <div class="detail-card flex justify-between items-center p-4 rounded-xl border border-gray-200">
                    <span class="text-gray-600 font-medium">Reference</span>
                    <span class="text-gray-900 font-mono text-sm">{{ $invoice->payment_reference }}</span>
                </div>
                
                <!-- Date -->
                <div class="detail-card flex justify-between items-center p-4 rounded-xl border border-gray-200">
                    <span class="text-gray-600 font-medium">Date</span>
                    <span class="text-gray-900 font-semibold">{{ $invoice->paid_at->format('d M Y, h:i A') }}</span>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-3">
            <a href="{{ route('invoice.show.receipt', $invoice->id) }}"
               class="flex-1 group relative inline-flex items-center justify-center bg-white hover:bg-gray-50 text-gray-700 font-bold py-4 px-8 rounded-xl border-2 border-gray-200 hover:border-gray-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                View Receipt
            </a>
            
            <a href="{{ route('invoice.show.receipt', $invoice->id) }}?download=1"
               class="flex-1 group relative inline-flex items-center justify-center bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-bold py-4 px-8 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Download Receipt
            </a>
        </div>

        <!-- Additional Info -->
        <p class="text-sm text-gray-500 mt-6">
            A confirmation email has been sent to your registered email address.
        </p>
    </div>

    <!-- Footer Note -->
    <div class="text-center mt-6 text-white text-sm opacity-90">
        <p>Need help? Contact our support team</p>
    </div>

</div>

</body>
</html>