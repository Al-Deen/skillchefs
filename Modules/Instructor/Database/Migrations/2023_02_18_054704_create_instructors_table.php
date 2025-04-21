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
        Schema::create('instructors', function (Blueprint $table) {
            $table->id();
            $table->longText('about_me')->nullable();
            $table->string('designation')->nullable();
            $table->string('address')->nullable();
            // $table->tinyInteger('is_enable')->default(1)->comment('1 = enable');
            // $table->tinyInteger('is_join_newsletter')->default(1)->comment('1 = enable');
            // $table->tinyInteger('is_allow_notification')->default(1)->comment('1 = enable');

            $table->tinyInteger('gender')->default(Gender::MALE)->comment('1 = male');
            $table->date('date_of_birth')->nullable();
            $table->json('badges')->nullable();

            // jubaer
            $table->json('education')->nullable();
            $table->json('experience')->nullable();
            $table->json('skills')->nullable();
            $table->double('commission')->default(20);
            $table->double('earnings')->default(0);
            $table->double('balance')->default(0);
            $table->double('points')->default(0);

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
        Schema::dropIfExists('instructors');
    }
};
