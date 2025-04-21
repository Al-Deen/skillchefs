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
        Schema::create('instructor_payment_methods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_method_id')->constrained('payment_methods')->onDelete('cascade'); // 1=active, 2=inactive
            $table->foreignId('status_id')->default(1)->constrained('statuses')->onDelete('cascade'); // 1=active, 2=inactive
            $table->json('credentials')->nullable(); // json data
            $table->tinyInteger('is_default')->default(0)->comment('1 = default');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            $table->index(['user_id']);
            $table->index(['payment_method_id','is_default']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('instructor_payment_methods');
    }
};
