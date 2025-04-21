<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payouts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('instructor_payment_method_id')->constrained('instructor_payment_methods')->onDelete('cascade');
            $table->double('amount', 8, 2);
            $table->foreignId('status_id')->default(3)->constrained('statuses')->onDelete('cascade'); // 3 = pending 4 = approved
            $table->foreignId('payment_status_id')->default(9)->constrained('statuses')->onDelete('cascade'); // 9 = pending 8 = paid
            $table->longText('payment_details')->nullable();
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
        Schema::dropIfExists('payouts');
    }
};
