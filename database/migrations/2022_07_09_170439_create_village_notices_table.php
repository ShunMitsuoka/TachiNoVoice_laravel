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
        Schema::create('village_notices', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('type')->comment('お知らせ種別');
            $table->unsignedBigInteger('village_id')->comment('ヴィレッジid');
            $table->text('content')->unique()->comment('内容');
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
        Schema::dropIfExists('village_notices');
    }
};
