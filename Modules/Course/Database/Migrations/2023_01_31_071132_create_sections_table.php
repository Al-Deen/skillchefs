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
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->string('title',255);
            $table->foreignId('course_id')->nullable()->constrained('courses')->onDelete('cascade');
            $table->integer('order')->default(1);

            $table->foreignId('status_id')->default(3)->constrained('statuses')->onDelete('cascade'); // 3 = pending

            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('cascade');

            $table->softDeletes();
            $table->timestamps();

            // index
            $table->index('title');
            $table->index('course_id','order');
            $table->index('status_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sections');
    }
};
