<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateInvoicesTable extends Migration
{
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            // Make specific fields nullable
            $table->string('phone_num')->nullable()->change();
            $table->string('email')->nullable()->change();
            $table->string('website')->nullable()->change();
            $table->string('bank_name')->nullable()->change();
            $table->string('account_num')->nullable()->change(); 
            $table->date('due_date')->nullable()->change();

            
            // Add payment_status column
            
            // Set default value for due_date if it's null (can be done at the application level)
            // If you'd like to ensure due_date is not null, we cannot directly do that via migration
            // but we can use a default value in the application code, which we've handled above.
        });
    }

    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            // Revert changes if rolling back the migration
            $table->string('phone_num')->nullable(false)->change();
            $table->string('email')->nullable(false)->change();
            $table->string('website')->nullable(false)->change();
            $table->string('bank_name')->nullable(false)->change();
            $table->string('account_num')->nullable(false)->change();
        });
    }
}

