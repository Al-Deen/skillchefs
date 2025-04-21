<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('payment_method')->nullable();
            $table->text('payment_details')->nullable();
            $table->json('payment_manual')->nullable();
            $table->string('invoice_number')->nullable();
            $table->double('amount', 8, 2);
            $table->double('discount_amount', 8, 2)->nullable();
            $table->double('total_amount', 8, 2);
            $table->double('paid_amount', 8, 2)->nullable();
            $table->double('due_amount', 8, 2)->nullable();
            $table->double('tax_amount', 8, 2)->nullable();
            $table->enum('status', ['unpaid', 'processing', 'paid','failed'])->default('unpaid');
            $table->tinyInteger('is_refunded')->default(0);
            $table->string('reference_id')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'payment_method', 'invoice_number', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
