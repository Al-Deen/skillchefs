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
        Schema::create('statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name', 30)->index()->comment('hare name=status situation');
            $table->string('class', 50)->index()->nullable()->comment('hare class=what type of class name property like success,danger,info,purple');
            $table->string('color_code')->nullable();
            // $table->string('type', 30)->index()->nullable()->comment('type means model type');
            $table->timestamps();
            // index
            $table->index(['name', 'class']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statuses');
    }
};
