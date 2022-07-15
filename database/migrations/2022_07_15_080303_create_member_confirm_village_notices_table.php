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
            $table->unsignedBigInteger('village_notice_id')->comment('ビレッジニュースid');
            $table->unsignedBigInteger('user_id')->comment('ユーザーid');
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
