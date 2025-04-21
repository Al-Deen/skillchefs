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
        Schema::create('assignment_submits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assignment_id')->nullable()->constrained('assignments')->onDelete('cascade');
            $table->foreignId('enroll_id')->nullable()->constrained('enrolls')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->double('marks', 8, 2)->default(0);
            $table->double('total_marks', 8, 2)->default(0);
            $table->double('point', 8, 2)->default(0);
            $table->foreignId('status_id')->default(3)->constrained('statuses')->onDelete('cascade'); // 3 = pending  24 = Fail  25 = Pass

            $table->longText('details')->nullable();
            $table->foreignId('assignment_file')->nullable()->constrained('uploads')->onDelete('set null');

            $table->boolean('is_reviewed')->default(false); // 0 = not reviewed  1 = reviewed
            
            $table->boolean('is_submitted')->default(false); // 0 = not reviewed  1 = reviewed

            $table->timestamps();

            // index
            $table->index('assignment_id', 'enroll_id');
            $table->index('is_submitted');

            $table->index(['user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assignment_submits');
    }
};
