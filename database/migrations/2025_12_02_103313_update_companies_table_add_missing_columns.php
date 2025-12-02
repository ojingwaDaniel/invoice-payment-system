<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('logo_path')->nullable()->after('address');
            $table->string('paystack_public_key')->nullable()->after('logo_path');
            $table->string('paystack_secret_key')->nullable()->after('paystack_public_key');
            $table->string('phone')->nullable()->after('paystack_secret_key');
            $table->string('email')->nullable()->after('phone');
        });
    }

    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn([
                'logo_path',
                'paystack_public_key',
                'paystack_secret_key',
                'phone',
                'email'
            ]);
        });
    }
};
