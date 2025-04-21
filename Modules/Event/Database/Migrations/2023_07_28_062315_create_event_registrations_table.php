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
        Schema::create('event_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('event_id')->constrained('events')->onDelete('cascade');
            $table->double('price')->nullable();
            $table->double('instructor_commission')->default(0);
            $table->enum('status', ['unpaid', 'processing', 'paid','failed'])->default('unpaid');
            $table->string('payment_method')->nullable();
            $table->longText('payment_details')->nullable();
            $table->json('payment_manual')->nullable();
            $table->string('invoice_number')->unique();
            $table->text('reference_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_registrations');
    }
};
