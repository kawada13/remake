<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InstrumentMaster extends Model
{
    protected $table = 'instruments';

    public function audios()
    {
        return $this->belongsToMany('App\Audio');
    }
}
