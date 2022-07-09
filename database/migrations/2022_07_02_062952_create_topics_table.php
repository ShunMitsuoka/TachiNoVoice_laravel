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
        Schema::create('topics', function (Blueprint $table) {
            $table->id()->comment('問題id');
            $table->unsignedBigInteger('village_id')->comment('ヴィレッジid');
            $table->string('title', 255)->unique()->comment('タイトル');
            $table->text('content')->comment('内容');
            $table->text('note')->comment('注意書き');
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
        Schema::dropIfExists('topics');
    }
};
