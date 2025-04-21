<?php

use App\Enums\GuardType;
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
        Schema::create('app_home_sections', function (Blueprint $table) {
            $table->id();
            $table->string('title',100);
            $table->string('snake_title',100)->nullable();
            $table->string('color',100)->default('#ffffff');
            $table->integer('order')->default(1);
            $table->foreignId('status_id')->default(1)->constrained('statuses')->onDelete('cascade'); // 1 = active 2 = inactive
            $table->string('type',20)->nullable(); // web, api type are available
            $table->tinyInteger('is_delete')->default(0); // web, api type are available
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
        Schema::dropIfExists('app_home_sections');
    }
};
