<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('address')->nullable();
            $table->string('phone_num')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('acc_num')->nullable();
            $table->string('website')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['address', 'phone_num', 'bank_name', 'acc_num', 'website']);
        });
    }
};

