<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAudioInstrumentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audio_instrument', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('audio_id');
            $table->unsignedBigInteger('instrument_id');
            $table->timestamps();

            // 外部キー設定
            $table->foreign('audio_id')->references('id')->on('audios');
            $table->foreign('instrument_id')->references('id')->on('instruments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('audio_instrument');
    }
}
