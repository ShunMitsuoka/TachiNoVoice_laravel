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
        Schema::create('member_confirm_village_notices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('village_notice_id')->comment('ヴィレッジニュースid');
            $table->unsignedBigInteger('village_id')->comment('ヴィレッジid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member_confirm_village_notices');
    }
};
