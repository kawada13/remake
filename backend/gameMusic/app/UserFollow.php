<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserFollow extends Model
{
    protected $table = 'user_follow';

    protected $fillable = [
        'follow_id', 'follower_id'
    ];
}
