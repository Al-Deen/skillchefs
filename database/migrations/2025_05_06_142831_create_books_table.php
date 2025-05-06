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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title',255);
            $table->string('slug',255)->unique();
            $table->unsignedBigInteger('instructor_id')->nullable();
            $table->json('point_title')->nullable();
            $table->json('point_description')->nullable();
            $table->longText('description')->nullable();
            $table->string('short_file')->nullable();
            $table->string('full_file')->nullable();
            $table->string('thumbnail')->nullable();
            $table->double('price',16,2)->nullable();
            $table->tinyInteger('is_free')->default(0)->comment('0 = paid, 1 = free');
            $table->integer('status')->default(1)->comment('0=>Inactive, 1=>Active');
            $table->integer('total_sales')->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
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
        Schema::dropIfExists('books');
    }
};
