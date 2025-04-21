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
        Schema::create('quiz_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->nullable()->constrained('lessons')->onDelete('cascade');
            $table->foreignId('enroll_id')->nullable()->constrained('enrolls')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->double('marks', 8, 2)->default(0);
            $table->double('total_marks', 8, 2)->default(0);
            $table->double('point', 8, 2)->default(0);
            $table->foreignId('is_submitted')->default(10)->constrained('statuses')->onDelete('cascade');
            $table->foreignId('status_id')->default(1)->constrained('statuses')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();

            // index
            $table->index('quiz_id');
            $table->index('user_id');
            $table->index('is_submitted', 'status_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quiz_results');
    }
};
