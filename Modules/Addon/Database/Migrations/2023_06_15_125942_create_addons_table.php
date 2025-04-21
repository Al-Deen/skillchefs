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
        Schema::create('addons', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->boolean('is_installed')->default(0); // 0 = not installed, 1 = installed
            $table->foreignId('status_id')->default(1)->constrained('statuses')->onDelete('cascade');
            $table->string('version')->nullable();
            $table->string('author')->nullable();
            $table->string('author_url')->nullable();
            $table->string('thumbnail')->nullable();
            $table->string('purchase_code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addons');
    }
};
