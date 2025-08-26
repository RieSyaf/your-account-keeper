<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id('invoice_id');
            $table->string('invoice_num')->nullable();
            $table->date('date')->nullable();
            $table->date('due_date');
            $table->string('sender_name');
            $table->text('sender_add');
            $table->text('receiver_add');
            $table->string('phone_num');
            $table->string('email');
            $table->string('website');
            $table->string('bank_name');
            $table->string('account_num');
            $table->decimal('total_price', 10, 2)->nullable();
            $table->enum('template', ['modern', 'minimalist']);
            $table->timestamps();
        });

        Schema::create('items', function (Blueprint $table) {
            $table->id('item_id');
            $table->string('item_name');
            $table->integer('item_quantity');
            $table->decimal('item_unitPrice', 10, 2);
            $table->decimal('item_totalPrice', 10, 2);
            $table->unsignedBigInteger('invoice_id');
            $table->foreign('invoice_id')->references('invoice_id')->on('invoices')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('items');
        Schema::dropIfExists('invoices');
    }
};
