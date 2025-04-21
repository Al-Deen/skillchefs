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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->double('amount', 8, 2);
            $table->double('discount_amount', 8, 2)->nullable();
            $table->double('total_amount', 8, 2)->default(0);
            $table->double('tax_amount', 8, 2)->default(0);
            
            $table->double('commission_amount', 8, 2)->default(0);
            $table->double('instructor_amount', 8, 2)->default(0);
            $table->timestamps();

            $table->index(['order_id', 'course_id']);

            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
    }
};
