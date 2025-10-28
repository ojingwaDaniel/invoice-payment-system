<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();

            // Link to invoice
            $table->foreignId('invoice_id')->constrained()->onDelete('cascade');

            // Payment details
            $table->decimal('amount', 10, 2);
            $table->string('method'); // e.g. cash, transfer, card, etc.
            $table->date('payment_date');
            $table->text('note')->nullable();

            // Timestamps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
