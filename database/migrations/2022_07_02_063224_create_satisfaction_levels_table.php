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
        Schema::create('satisfaction_levels', function (Blueprint $table) {
            $table->id()->comment('満足度id');
            $table->unsignedBigInteger('policy_id')->comment('方針id');
            $table->unsignedTinyInteger('satisfaction_level')->comment('満足度');
            $table->text('impressions')->comment('感想');
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
        Schema::dropIfExists('satisfaction_levels');
    }
};
