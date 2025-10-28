<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();

            // Relations
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');

            // Invoice info
            $table->string('invoice_number')->unique();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');

            $table->decimal('total_amount', 10, 2)->default(0);
            $table->decimal('paid', 10, 2)->default(0);
            $table->enum('status', ['paid', 'unpaid', 'partial'])->default('unpaid');
            $table->string('payment_method')->nullable();

            $table->date('issue_date')->nullable();
            $table->date('due_date')->nullable();

            $table->string('currency')->default('NGN');
            $table->decimal('discount', 10, 2)->default(0);
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
