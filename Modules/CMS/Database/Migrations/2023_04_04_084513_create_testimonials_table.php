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
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('designation');
            $table->foreignId('image_id')->nullable()->constrained('uploads')->onDelete('cascade');
            $table->text('content');
            $table->integer('rating')->default(0);
            $table->foreignId('status_id')->default(1)->constrained('statuses')->onDelete('cascade'); // 1=active, 2=inactive
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
        Schema::dropIfExists('testimonials');
    }
};
