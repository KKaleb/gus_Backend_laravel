<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('new_votes', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('code')->nullable();
            $table->dateTime('expiry')->nullable();
            $table->boolean('is_verified')->default(false);
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
        Schema::dropIfExists('new_votes');
    }
}
