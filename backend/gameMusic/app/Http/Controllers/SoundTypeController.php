<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

// モデル
use App\UseMaster;
use App\InstrumentMaster;
use App\SoundMaster;
use App\UnderstaindingMaster;

class SoundTypeController extends Controller
{
    // サウンド一覧を取得
    public function sound() {
        try{
            $sounds = SoundMaster::all();

            return response()->json([
                'message' => '成功',
                'sounds' => $sounds
            ], 200);
        }
        catch (\Exception $e) {
            return response()->json([
                'message' => '失敗',
                'errorInfo' => $e
            ],500);
        }
    }
}
