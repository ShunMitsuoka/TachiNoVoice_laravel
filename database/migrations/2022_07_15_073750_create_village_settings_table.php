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
        Schema::create('village_settings', function (Blueprint $table) {
            $table->id()->comment('ビレッジ参加条件設定id');
            $table->unsignedBigInteger('village_id')->comment('ビレッジid');
            $table->Integer('core_member_limit')->nullable()->comment('コアメンバー最大人数');
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
        Schema::dropIfExists('village_settings');
    }
};
