<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            // Drop the existing foreign key if it exists
            $table->dropForeign(['user_id']); // Drop the existing foreign key constraint if it exists

            // Make the user_id column NOT NULL and add the foreign key constraint
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            // Revert the user_id column to be nullable and remove the foreign key constraint
            $table->unsignedBigInteger('user_id')->nullable()->change();
            $table->dropForeign(['user_id']);
        });
    }
};
