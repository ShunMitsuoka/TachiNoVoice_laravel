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
        Schema::create('public_informations', function (Blueprint $table) {
            $table->id()->comment('コアメンバー情報開示id');
            $table->unsignedBigInteger('village_id')->comment('ビレッジid');
            $table->boolean('nickname_flg')->comment('ニックネーム表示フラグ');
            $table->boolean('gender_flg')->comment('性別表示フラグ');
            $table->boolean('age_flg')->comment('年齢表示フラグ');
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
        Schema::dropIfExists('public_informations');
    }
};
