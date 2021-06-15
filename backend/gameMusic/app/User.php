<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use Notifiable;
    use Billable;

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

  public function favorite_audios()
    {
        return $this->belongsToMany('App\Audio', 'favorites', 'user_id', 'audio_id');
    }

    public function followings()
    {
        return $this->belongsToMany('App\User', 'user_follow', 'follow_id', 'follower_id');
    }

    public function followers()
    {
        return $this->belongsToMany('App\User', 'user_follow', 'follower_id', 'follow_id');
    }
    public function purchase_audios()
    {
        return $this->belongsToMany('App\Audio', 'purchase_records', 'user_id', 'audio_id');
    }

    public function chatMessages()
    {
        return $this->hasMany('App\ChatMessage');
    }

    public function chatRoomUsers()
    {
        return $this->hasMany('App\ChatRoomUsers');
    }
    public function recruitments()
    {
        return $this->hasMany('App\Recruitment');
    }



}
