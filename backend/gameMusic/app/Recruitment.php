<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recruitment extends Model
{
    protected $table = 'recruitments';

    protected $fillable = [
        'user_id', 'title', 'budget', 'content'
    ];

    // リレーション
    Public function user()
     {
       return $this->belongsTo('App\User');
     }
}
