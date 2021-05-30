<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    // リレーション
    Public function userInformation()
  {
    return $this->hasOne('App\UserInformation');
  }
    Public function transfer_account()
  {
    return $this->hasOne('App\TransferAccount');
  }

    public function audios()
  {
      return $this->hasMany('App\Audio');
  }



}
