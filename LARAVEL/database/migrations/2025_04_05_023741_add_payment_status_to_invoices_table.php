<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentStatusToInvoicesTable extends Migration
{
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            // Add the payment_status column with the enum values
            $table->enum('payment_status', ['paid', 'unpaid', 'pending'])->default('pending');
        });
    }

    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            // Drop the payment_status column
            $table->dropColumn('payment_status');
        });
    }
}
