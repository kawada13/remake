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
}
