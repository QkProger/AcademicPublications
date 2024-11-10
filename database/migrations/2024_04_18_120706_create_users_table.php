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
            $table->string('name');
            $table->string('second_name');
            $table->string('surname');
            $table->string('fio');
            $table->string('phone');
            $table->string('iin');
            $table->string('email');
            $table->string('job');
            $table->string('password');
            $table->string('real_password');
            $table->boolean('is_active');
            $table->string('lang_code')->default('kz');
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
