<?php

use App\Enums\Gender;
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
        Schema::create('ambassadors', function (Blueprint $table) {
            $table->id();
            $table->longText('about_me')->nullable();
            $table->string('designation')->nullable();
            $table->string('address')->nullable();
            $table->string('university')->nullable();
            $table->string('graduation_year')->nullable();
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

            $table->json('question_title')->nullable();
            $table->json('question_answer')->nullable();
            $table->string('cv')->nullable();

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
        Schema::dropIfExists('ambassadors');
    }
};
