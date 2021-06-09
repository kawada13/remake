<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Cashier\Billable;

class PurchaseRecord extends Model
{
    use Billable;


    protected $table = 'purchase_records';

    protected $fillable = [
        'user_id', 'audio_id', 'stripe_id', 'status', 'withdraw_at', 'price'
    ];

    // リレーション
    Public function user()
     {
       return $this->belongsTo('App\User');
     }
    Public function audio()
     {
       return $this->belongsTo('App\Audio');
     }

}
