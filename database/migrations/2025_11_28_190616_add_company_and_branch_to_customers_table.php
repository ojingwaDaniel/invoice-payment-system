<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->foreignId('company_id')->constrained('companies')->cascadeOnDelete()->after('id');
            $table->foreignId('branch_id')->nullable()->constrained('branches')->cascadeOnDelete()->after('company_id');
        });
    }

    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            // Drop foreign keys first
            $table->dropForeign(['company_id']);
            $table->dropForeign(['branch_id']);

            // Then drop the columns
            $table->dropColumn(['company_id', 'branch_id']);
        });
    }
};
