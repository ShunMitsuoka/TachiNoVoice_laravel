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
        Schema::create('village_members', function (Blueprint $table) {
            $table->id()->comment('ビレッジメンバーid');
            $table->unsignedBigInteger('user_id')->comment('ユーザーid');
            $table->unsignedBigInteger('village_id')->comment('ビレッジid');
            $table->unsignedTinyInteger('role_id')->comment('権限id');
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
        Schema::dropIfExists('village_members');
    }
};
