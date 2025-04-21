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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('username')->nullable();
            $table->string('email')->unique();
            $table->date('date_of_birth')->nullable();
            $table->tinyInteger('gender')->default(App\Enums\Gender::MALE);
            $table->timestamp('email_verified_at')->nullable()->comment('if null then verified, not null then not verified');
            $table->string('token')->nullable()->comment('Token for phone verification, if null then verified, not null then not verified');
            $table->string('phone')->nullable();
            $table->string('password');
            $table->text('permissions')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->tinyInteger('status')->default(App\Enums\Status::ACTIVE);

            $table->double('event_commission', 8, 2)->default(0);

            $table->foreignId('status_id')->default(3)->constrained('statuses')->onDelete('cascade'); // 3 = pending 4 = approved 5 = suspended 6 = rejected

            $table->unsignedBigInteger('image_id')->nullable();
            $table->foreign('image_id')->references('id')->on('uploads')->onDelete('set null');

            $table->unsignedBigInteger('role_id')->nullable();
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('set null');

            $table->unsignedBigInteger('designation_id')->nullable();
            $table->string('device_token')->nullable();

            $table->string('facebook_id')->nullable();
            $table->string('google_id')->nullable();
            $table->string('github_id')->nullable();
            $table->string('linkedin_id')->nullable();

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
