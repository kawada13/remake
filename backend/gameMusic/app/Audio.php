<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Audio extends Model
{
    protected $table = 'audios';

    protected $fillable = [
        'user_id', 'sound_id', 'title', 'price', 'audio_file'
    ];

     // リレーション
     Public function user()
     {
       return $this->belongsTo('App\User');
     }
    //  いるかわからないけど中間テーブル自体へのリレーション
     public function audioInstruments()
    {
        return $this->hasMany('App\AudioInstrument');
    }
     public function audioUnderstandings()
    {
        return $this->hasMany('App\AudioUnderstanding');
    }
     public function audioUses()
    {
        return $this->hasMany('App\AudioUse');
    }
    // 多対多リレーション
     public function instruments()
    {
        return $this->belongsToMany('App\InstrumentMaster', 'audio_instrument', 'audio_id', 'instrument_id');
    }
     public function uses()
    {
        return $this->belongsToMany('App\UseMaster', 'audio_use', 'audio_id', 'use_id');
    }
     public function understandings()
    {
        return $this->belongsToMany('App\UnderstaindingMaster', 'audio_understanding', 'audio_id', 'understanding_id');
    }
}
