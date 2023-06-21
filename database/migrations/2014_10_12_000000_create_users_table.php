<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('password');
            $table->bigInteger('phone_number')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('device_token')->nullable();
            $table->string('access_token')->nullable();
            $table->enum('user_type', [0, 1])->default('0')->comment('0:Admin,1:User')->nullable();
            $table->enum('status', ['0', '1'])->default('1');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
