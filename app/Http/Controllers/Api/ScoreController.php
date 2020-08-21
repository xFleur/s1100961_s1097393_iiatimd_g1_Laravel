<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Post;
use App\Comment;
use App\Like;
use App\Score;
use Illuminate\Support\Facades\Auth;

class ScoreController extends Controller
{
//this function saves user high score
    public function save_user_score(Request $request){

        $score = new Score;

        try{
            $score->highscore = $request->highscore;
            $score->leadname = $request->leadname;
            $score->save();
            return response()->json([
                'success' => true,
                'message' => 'score success'
            ]);
        }
        catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => ''.$e
            ]);
        }
    }


//this function showes all user high scores leaderboard
    public function leaderboard() {    
        try {
        $score->highscore = $request->highscore;
        $score->leadname = $request->leadname;
        $score->update();

        return response()->json([
            'success' => true,
            'message' => 'get leaderbaord  success'
        ]);

    }
    catch(Exception $e) {
        return response()->json([
            'success' => false,
            'message' => ''.$e
        ]);
    }
    }


}