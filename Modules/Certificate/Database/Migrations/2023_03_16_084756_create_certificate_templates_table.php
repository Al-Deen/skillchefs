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
        Schema::create('certificate_templates', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('image_id')->nullable()->constrained('uploads')->onDelete('cascade');
            $table->text('text')->nullable();
            $table->tinyInteger('is_rtl')->default(0);
            $table->foreignId('default_id')->default(10)->constrained('statuses')->onDelete('cascade'); // 10 = no, 11 = yes
            $table->foreignId('status_id')->default(1)->constrained('statuses')->onDelete('cascade'); // 1 = active, 2 = inactive
            $table->foreignId('font_id')->nullable()->constrained('uploads')->onDelete('cascade');
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
        Schema::dropIfExists('certificate_templates');
    }
};
