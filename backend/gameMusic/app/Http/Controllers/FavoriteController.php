<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

// モデル
use App\User;
use App\Audio;
use App\AudioInstrument;
use App\AudioUnderstanding;
use App\AudioUse;

class FavoriteController extends Controller
{
    // ユーザーがオーディオをお気に入りする
    public function store($id)
    {
        $audio = Audio::find($id);

        // 既にお気に入りしていたらもう一度お気に入りすることを拒否する
        $is_favorite = $audio->favorite_users()
                                ->where('')





        $audio->favorite_users()->attach(Auth::id());



    }

    public function delete($id)
    {
        $audio = Audio::find($id);
        $audio->favorite_users()->attach(Auth::id());
    }
}
