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
            $table->id()->comment('ユーザーid');
            $table->string('email', 255)->unique()->comment('メールアドレス');
            $table->string('password', 255)->nullable()->comment('パスワード');
            $table->string('user_name', 255)->comment('ユーザ名称');
            $table->string('nickname', 255)->nullable()->comment('ニックネーム');
            $table->boolean('gender')->comment('性別');
            $table->date('date_of_birth')->comment('生年月日');
            $table->timestamps();
            $table->boolean('deleted_flg')->default(0);
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
