<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Enums\Gender;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->longText('about_me')->nullable();
            $table->string('designation')->nullable();
            $table->string('address')->nullable();
            $table->tinyInteger('gender')->default(Gender::MALE)->comment('1 = male');
            $table->date('date_of_birth')->nullable();
            $table->json('badges')->nullable();
            $table->json('skills')->nullable();
            $table->double('earnings')->default(0);
            $table->double('balance')->default(0);
            $table->double('points')->default(0);
            $table->foreignId('country_id')->nullable()->constrained('countries')->onDelete('set null');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('status_id')->default(1)->constrained('statuses')->onDelete('cascade');
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
        Schema::dropIfExists('organizations');
    }
};
