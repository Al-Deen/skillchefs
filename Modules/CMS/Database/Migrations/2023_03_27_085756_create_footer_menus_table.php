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
        Schema::create('footer_menus', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('column')->default(1)->comment('1=column 1, 2=column 2, 3=column 3');
            $table->json('links')->nullable();
            $table->foreignId('status_id')->default(1)->constrained('statuses')->onDelete('cascade'); // 1=active, 2=inactive
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
        Schema::dropIfExists('footer_menus');
    }
};
