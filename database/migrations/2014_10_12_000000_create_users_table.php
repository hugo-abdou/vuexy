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
            // Default fields
            $table->id();
            $table->string('fullName');
            $table->string('email')->unique();
            $table->string('password');
            // Custom fields
            $table->boolean('status')->default(0);
            $table->string('profile_photo_path')->nullable();
            $table->string('phone')->nullable();
            $table->longText('bio')->nullable();
            $table->timestamp('birth_date')->nullable();
            $table->string('country')->nullable();
            // Default fields
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
