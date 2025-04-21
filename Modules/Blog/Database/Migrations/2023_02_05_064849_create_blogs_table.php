<?php

use App\Enums\Status;
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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->string('slug', 255)->unique(); // Index
            $table->longText('description');


            $table->foreignId('image_id')->nullable()->constrained('uploads')->onDelete('set null');
            $table->foreignId('status_id')->default(1)->constrained('statuses')->onDelete('cascade');
            $table->foreignId('blog_categories_id')->default(1)->constrained('blog_categories')->onDelete('cascade');

            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('deleted_by')->nullable()->constrained('users')->onDelete('cascade');


             // start meta tags
             $table->longText('meta_title')->nullable();
             $table->longText('meta_description')->nullable();
             $table->longText('meta_keywords')->nullable();
             $table->foreignId('meta_image_id')->nullable()->constrained('uploads')->onDelete('set null');
             // end meta tags

            //Soft delete creates a deleted_at column
            $table->softDeletes();
            //Soft delete creates a deleted_at column

            $table->timestamps();

            //index
            $table->index(['title','status_id','blog_categories_id','created_by']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog');
    }
};
