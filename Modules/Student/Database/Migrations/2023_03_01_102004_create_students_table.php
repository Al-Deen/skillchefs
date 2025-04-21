<?php

use App\Enums\Gender;
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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->longText('about_me')->nullable();
            $table->string('designation')->nullable();
            $table->string('address')->nullable();

            $table->tinyInteger('gender')->default(Gender::MALE)->comment('1 = male');
            $table->date('date_of_birth')->nullable();
            $table->json('badges')->nullable();

            // jubaer
            $table->json('education')->nullable();
            $table->json('experience')->nullable();
            $table->json('skills')->nullable();

            $table->integer('points')->default(0);

            $table->foreignId('country_id')->nullable()->constrained('countries')->onDelete('set null');
            //Foreign key with relation users table
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            //Foreign key with relation users table
            $table->timestamps();

            //index
            $table->index(['user_id','country_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
};
