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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200)->nullable();
            $table->string('ac_name', 200)->nullable();
            $table->string('ac_number', 100)->nullable();
            $table->string('code', 200)->nullable();
            $table->string('branch', 200)->nullable();
            $table->double('balance', 16, 2)->default(0);
            $table->foreignId('status_id')->default(1)->constrained('statuses')->onDelete('cascade'); // 1 = active, 2 = inactive
            $table->tinyInteger('is_default')->default(0)->comment('0 = no, 1 = yes');
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
        Schema::dropIfExists('accounts');
    }
};
