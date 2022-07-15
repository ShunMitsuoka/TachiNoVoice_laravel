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
        Schema::create('village_member_requirements', function (Blueprint $table) {
            $table->id()->comment('ビレッジメンバー条件設定id');
            $table->unsignedBigInteger('village_id')->comment('ビレッジid');
            $table->text('requirement')->nullable()->comment('条件');
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
        Schema::dropIfExists('village_member_requirements');
    }
};
