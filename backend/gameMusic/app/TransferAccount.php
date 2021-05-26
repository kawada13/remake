<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransferAccount extends Model
{
    protected $table = 'transfer_accounts';

    // リレーション
    Public function user()
     {
       return $this->belongsTo('App\User');
     }
}
