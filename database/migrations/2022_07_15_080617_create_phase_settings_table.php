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
        Schema::create('phase_settings', function (Blueprint $table) {
            $table->id()->comment('フェーズ条件id');
            $table->unsignedBigInteger('phase_id')->comment('フェーズid');
            $table->boolean('end_flg')->default(1)->comment('0:終了 1:開始');
            $table->boolean('by_manual_flg')->default(1)->comment('手動フラグ');
            $table->boolean('by_limit_flg')->default(0)->comment(' 限界値フラグ');
            $table->boolean('by_date_flg')->default(0)->comment('日付フラグ');
            $table->datetime('border_date')->nullable()->comment('日付');
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
        Schema::dropIfExists('phase_settings');
    }
};
