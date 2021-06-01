<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAudiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->comment('外部キー');
            $table->foreignId('sound_id')->constrained()->comment('外部キー');
            $table->string('title')->comment('オーディオタイトル');
            $table->integer('price')->comment('価格');
            $table->string('audio_file')->comment('オーディオファイル');
            $table->string('sample_audio_file')->comment('サンプルオーディオファイル');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('audios');
    }
}
