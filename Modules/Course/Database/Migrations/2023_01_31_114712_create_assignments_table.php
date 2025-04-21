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
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->foreignId('course_id')->nullable()->constrained('courses')->onDelete('cascade');
            $table->longText('details')->nullable();
            $table->foreignId('assignment_file')->nullable()->constrained('uploads')->onDelete('set null');
            $table->double('marks', 8, 2)->default(0);
            $table->double('pass_marks', 8, 2)->default(0);
            $table->timestamp('deadline')->nullable();
            $table->longText('note')->nullable();
            $table->foreignId('status_id')->default(21)->constrained('statuses')->onDelete('cascade');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('cascade');
            $table->tinyInteger('is_notify')->default(0);
            $table->timestamps();

            $table->double('point', 8, 2)->default(0);

            // index
            $table->index('title', 'course_id');
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
        Schema::dropIfExists('assignments');
    }
};
