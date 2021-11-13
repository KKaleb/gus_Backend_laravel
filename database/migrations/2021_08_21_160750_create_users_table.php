<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('pin')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('phone_number')->unique();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();//
            $table->string('last_name')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('name_next_of_kin')->nullable();//
            $table->string('phone_number_next_of_kin')->nullable();//
            $table->string('dob')->nullable();
            $table->string('age')->nullable();
            $table->string('height')->nullable();
            $table->string('weight')->nullable();//
            $table->string('bias_against_alcohol')->nullable();
            $table->text('hobbies')->nullable();
            $table->string('work')->nullable();
            $table->string('gender')->nullable();
            $table->string('address')->nullable();
            $table->string('home_address')->nullable();
            $table->string('state_of_origin')->nullable();
            $table->string('lga')->nullable();
            $table->string('state_of_residence')->nullable();
            $table->string('how_often')->nullable();
            $table->string('medical_challenge')->nullable();
            $table->longText('bio')->nullable();
            $table->string('video_url')->nullable();
            $table->string('image_url')->nullable();
            $table->boolean('is_submitted')->default(false);
            $table->boolean('is_admin')->default(false);
            $table->string('status')->default('PENDING');
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
}
