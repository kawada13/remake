<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AudioInstrument extends Model
{
    protected $table = 'audio_instrument';

    protected $fillable = [
        'audio_id', 'instrument_id'
    ];
}
