<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $table = 'favorites';

    protected $fillable = [
        'user_id', 'audio_id'
    ];

    // リレーション
    public function user()
     {
         return $this->belongsTo('App\User');
     }
    public function audio()
     {
         return $this->belongsTo('App\Audio');
     }
}
