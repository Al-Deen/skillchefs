<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Validation\Rules\Enum;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title',255);
            $table->string('slug',255)->unique();
            $table->string('short_description',255)->nullable();
            $table->longText('description')->nullable();
            $table->foreignId('course_category_id')->nullable()->constrained('course_categories')->onDelete('cascade');

            // start course info
            $table->longText('requirements')->nullable();
            $table->longText('outcomes')->nullable();
            $table->longText('faq')->nullable();
            $table->longText('tags')->nullable();
            // end course info

            // start meta tags
            $table->longText('meta_title')->nullable();
            $table->longText('meta_description')->nullable();
            $table->longText('meta_keywords')->nullable();
            $table->longText('meta_author')->nullable();
            $table->foreignId('meta_image')->nullable()->constrained('uploads')->onDelete('set null');
            // end meta tags

            // course media
            $table->foreignId('thumbnail')->nullable()->constrained('uploads')->onDelete('set null');
            $table->foreignId('course_overview_type')->nullable()->constrained('statuses')->onDelete('cascade'); // 15 = youtube, 16 = vimeo, 17 = html5 24 = Image Only
            $table->string('video_url',255)->nullable();
            $table->string('language',255)->default('en');
            // course media


            // course type [live, recorded, text]
            $table->foreignId('course_type',255)->default(13)->constrained('statuses')->onDelete('cascade');
            // course type

            // start course is admin
            $table->tinyInteger('is_admin')->default(11)->constrained('statuses')->onDelete('cascade');
            // end course is admin

            // start price
            $table->double('price',16,2)->nullable();
            $table->tinyInteger('is_discount')->default(10)->constrained('statuses')->onDelete('cascade');
            $table->tinyInteger('discount_type')->default(1)->comment('2 = percentage, 1 = fixed');
            $table->double('discount_price',16,2)->nullable();
            $table->date('discount_start_date')->nullable();
            $table->date('discount_end_date')->nullable();
            // end price


            // course multiple instructors
            $table->foreignId('instructor_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->tinyInteger('is_multiple_instructor')->default(0)->comment('0 = false, 1 = true');
            $table->json('partner_instructors')->nullable();
            // course multiple instructors



            $table->tinyInteger('is_free')->default(0)->comment('0 = false, 1 = true');
            $table->foreignId('level_id')->default(18)->constrained('statuses')->onDelete('cascade');
            $table->foreignId('status_id')->default(3)->constrained('statuses')->onDelete('cascade'); // 3 = pending
            $table->foreignId('visibility_id')->default(22)->constrained('statuses')->onDelete('cascade'); // 23 = private and 22 = public and 21 = draft

            // last modified
            $table->timestamp('last_modified')->nullable();
            // last modified

            // review
            $table->double('rating')->default(0.00);
            $table->integer('total_review')->default(0);
            // review

            // total sales
            $table->integer('total_sales')->default(0);
            $table->double('course_duration')->default(0.00);
            $table->double('point', 8, 2)->default(0);

            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('deleted_by')->nullable()->constrained('users')->onDelete('cascade');

            $table->softDeletes();
            $table->timestamps();

            //index
            $table->index('title','is_free');
            $table->index('status_id','instructor_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
    }
};
