<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AudioUnderstanding extends Model
{
    protected $table = 'audio_understanding';

    protected $fillable = [
        'audio_id', 'understanding_id'
    ];
}
