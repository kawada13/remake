<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAudioUseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audio_use', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('audio_id');
            $table->unsignedBigInteger('use_id');
            $table->timestamps();

            // 外部キー設定
            $table->foreign('audio_id')->references('id')->on('audios');
            $table->foreign('use_id')->references('id')->on('uses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('audio_use');
    }
}
