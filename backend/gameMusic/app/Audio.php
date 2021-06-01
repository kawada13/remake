<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Audio extends Model
{
    use SoftDeletes;

    protected $table = 'audios';

    protected $fillable = [
        'user_id', 'sound_id', 'title', 'price', 'audio_file'
    ];

     // リレーション
     Public function user()
     {
       return $this->belongsTo('App\User');
     }
     public function sound()
     {
         return $this->belongsTo('App\SoundMaster');
     }
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

    public function favorite_users()
    {
        return $this->belongsToMany('App\User', 'favorites', 'audio_id', 'user_id');
    }
}
