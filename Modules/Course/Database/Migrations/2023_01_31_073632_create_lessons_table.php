<?php

use App\Enums\LessonEnum;
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
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->tinyInteger('is_quiz')->default(0)->comment('0 = false, 1 = true');
            $table->tinyInteger('is_timer')->default(0)->comment('0 = false, 1 = true');
            $table->string('duration', 255)->nullable();
            $table->double('point', 8, 2)->default(0);
            $table->foreignId('section_id')->nullable()->constrained('sections')->onDelete('cascade');
            $table->foreignId('course_id')->nullable()->constrained('courses')->onDelete('cascade');
            $table->tinyInteger('is_free')->default(0)->comment('0 = false, 1 = true');
            $table->enum('lesson_type', LessonEnum::getKeysName())->nullable();
            $table->string('video_url', 255)->nullable();
            $table->string('video_type', 255)->nullable();

            // video file
            $table->foreignId('video_file')->nullable()->constrained('uploads')->onDelete('cascade');

            // attachment
            $table->tinyInteger('attachment_type')->default(0)->comment('0 = file, 1 = link');
            $table->foreignId('attachment')->nullable()->constrained('uploads')->onDelete('cascade');
            // attachment

            //image_file
            $table->foreignId('image_file')->nullable()->constrained('uploads')->onDelete('cascade');

            $table->tinyInteger('is_online_view')->default(0)->comment('0 = false, 1 = true');
            $table->tinyInteger('is_downloadable')->default(0)->comment('0 = false, 1 = true');

            // iframe source
            $table->longText('iframe')->nullable();
            // iframe source
            // lesson text
            $table->longText('lesson_text')->nullable();
            // lesson text
            $table->longText('content')->nullable();
            $table->integer('order')->default(1);

            // for quiz
            $table->integer('marks')->default(0);
            $table->integer('pass_marks')->default(0);
            $table->longText('instruction')->nullable();


            // last modified 
            $table->timestamp('last_modified')->nullable();
            // last modified


            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('cascade');

            $table->foreignId('status_id')->default(21)->constrained('statuses')->onDelete('cascade');



            $table->softDeletes();
            $table->timestamps();

            // index
            $table->index('title','is_free');
            $table->index('section_id');
            $table->index('course_id','order');
            $table->index('is_quiz');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lessons');
    }
};
