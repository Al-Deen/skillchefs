<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->string('address')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('thumbnail')->nullable()->constrained('uploads')->onDelete('cascade');
            $table->enum('event_type', ['Online', 'Offline'])->nullable();
            $table->string('online_welcome_media')->nullable();
            $table->string('online_media')->nullable();
            $table->string('online_link')->nullable();
            $table->text('online_note')->nullable();
            $table->timestamp('start')->nullable();
            $table->timestamp('end')->nullable();
            $table->timestamp('registration_deadline')->nullable();
            $table->string('tags')->nullable();
            $table->integer('max_participant')->nullable();
            $table->foreignId('show_participant')->default(22)->constrained('statuses')->onDelete('cascade')->comment('22 = public, 23 = private'); // 22 = public, 23 = private
            $table->foreignId('visibility_id')->default(22)->constrained('statuses')->onDelete('cascade')->comment('22 = public, 23 = private'); // 22 = public, 23 = private
            $table->foreignId('is_paid')->default(10)->constrained('statuses')->onDelete('cascade');
            $table->double('price')->nullable();
            $table->foreignId('category_id')->nullable()->constrained('event_categories')->onDelete('cascade');
            $table->foreignId('status_id')->default(1)->constrained('statuses')->onDelete('cascade');
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
};
