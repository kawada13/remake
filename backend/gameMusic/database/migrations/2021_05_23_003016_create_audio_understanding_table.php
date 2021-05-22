<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAudioUnderstandingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audio_understanding', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('audio_id');
            $table->unsignedBigInteger('understanding_id');
            $table->timestamps();

            // 外部キー設定
            $table->foreign('audio_id')->references('id')->on('audios');
            $table->foreign('understanding_id')->references('id')->on('understandings');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('audio_understanding');
    }
}
