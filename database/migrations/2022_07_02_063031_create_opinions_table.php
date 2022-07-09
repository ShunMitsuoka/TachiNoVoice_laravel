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
        Schema::create('options', function (Blueprint $table) {
            $table->id()->comment('意見id');
            $table->unsignedBigInteger('topic_id')->comment('問題id');
            $table->unsignedBigInteger('user_id')->comment('ユーザーid');
            $table->unsignedBigInteger('category_id')->comment('カテゴリーid');
            $table->text('opinion')->comment('意見');
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
        Schema::dropIfExists('opinions');
    }
};
