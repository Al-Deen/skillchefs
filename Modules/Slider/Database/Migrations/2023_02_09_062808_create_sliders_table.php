<?php

use Illuminate\Support\Facades\DB;
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
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255)->nullable();
            $table->string('sub_title', 255)->nullable();
            $table->longText('description')->nullable();
            $table->unsignedBigInteger('serial')->unique();
            $table->string('button_text')->nullable();
            $table->text('button_url')->nullable();

            $table->foreignId('image_id')->nullable()->constrained('uploads')->onDelete('set null');
            $table->foreignId('status_id')->default(1)->constrained('statuses')->onDelete('cascade');


            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('deleted_by')->nullable()->constrained('users')->onDelete('cascade');

            $table->timestamps();

            //index
            $table->index(['title','sub_title','status_id','created_by','serial']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sliders');
    }
};
