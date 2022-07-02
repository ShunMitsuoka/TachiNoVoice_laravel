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
        Schema::create('participation_conditions', function (Blueprint $table) {
            $table->id()->comment('条件設定id');
            $table->unsignedBigInteger('village_id')->comment('ビレッジid');
            $table->unsignedTinyInteger('member_roll')->comment('メンバー権限');
            $table->unsignedBigInteger('member_capacity')->comment('定員');
            $table->datetime('recruitment_start')->comment('募集開始');
            $table->datetime('recruitment_end')->comment('募集終了');
            $table->boolean('selection_method')->comment('選考方法');
            $table->text('condition')->comment('条件');
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
        Schema::dropIfExists('participation_conditions');
    }
};
