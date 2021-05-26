<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransferAccount extends Model
{
    protected $table = 'transfer_accounts';

    protected $fillable = [
        'user_id', 'bank_name', 'bank_code', 'branch_name', 'branch_number', 'deposit_type', 'account_number', 'account_holder'
    ];

    // リレーション
    Public function user()
     {
       return $this->belongsTo('App\User');
     }
}
