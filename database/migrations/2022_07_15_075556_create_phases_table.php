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
        Schema::create('phases', function (Blueprint $table) {
            $table->id()->comment('フェーズid');
            $table->unsignedBigInteger('village_id')->comment('ビレッジid');
            $table->unsignedTiniyInteger('m_phase_id')->comment('フェーズマスタid');
            $table->unsignedTiniyInteger('m_phase_status_id')->comment('フェーズステータスマスタid');
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
        Schema::dropIfExists('phases');
    }
};
