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
        Schema::create('enrolls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_item_id')->constrained('order_items')->onDelete('cascade');
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('instructor_id')->constrained('users')->onDelete('cascade');
            $table->integer('progress')->default(0);
            $table->boolean('is_completed')->default(false);
            $table->json('completed_lessons')->nullable();
            $table->json('completed_quizzes')->nullable();
            $table->json('completed_assignments')->nullable();
            
            $table->double('lesson_point', 8, 2)->default(0);
            $table->double('quiz_point', 8, 2)->default(0);
            $table->double('assignment_point', 8, 2)->default(0);

            $table->timestamp('visited')->nullable();
            $table->timestamp('completed_at')->nullable();
            
            $table->timestamps();
            $table->index(['order_item_id', 'course_id', 'user_id']);
            $table->index(['instructor_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enrolls');
    }
};
