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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->longText('title',800);
            $table->foreignId('quiz_id')->nullable()->constrained('lessons')->onDelete('cascade');
            $table->foreignId('course_id')->nullable()->constrained('courses')->onDelete('cascade');
            $table->tinyInteger('type')->default(0)->comment('0 = single and true/false, 1 = multiple', '2 = true/false', '3 = fill in the blanks');
            $table->integer('total_options')->default(0);
            $table->longText('options')->nullable();
            $table->longText('answer')->nullable();

            $table->foreignId('status_id')->default(1)->constrained('statuses')->onDelete('cascade');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('deleted_by')->nullable()->constrained('users')->onDelete('cascade');
            $table->integer('order')->default(1);

            $table->softDeletes();
            $table->timestamps();

            // index
            $table->index('quiz_id');
            $table->index('course_id','status_id');
            $table->index('type', 'order');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
};
