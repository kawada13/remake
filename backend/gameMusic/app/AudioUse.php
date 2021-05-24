<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AudioUse extends Model
{
    protected $table = 'audio_use';

    protected $fillable = [
        'audio_id', 'use_id'
    ];
}
