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
        Schema::create('event_schedule_lists', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('details');
            $table->time('from_time');
            $table->time('to_time');
            $table->string('location');
            $table->foreignId('status_id')->default(1)->constrained('statuses')->onDelete('cascade');
            $table->foreignId('created_by')->default(1)->constrained('users')->onDelete('cascade');
            $table->foreignId('event_schedule_id')->default(1)->constrained('event_schedules')->onDelete('cascade');
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
        Schema::dropIfExists('event_schedule_lists');
    }
};
