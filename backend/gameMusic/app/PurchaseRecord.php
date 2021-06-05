<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseRecord extends Model
{
    protected $table = 'purchase_records';

    protected $fillable = [
        'user_id', 'audio_id', 'stripe_id', 'status', 'withdraw_at'
    ];

}
