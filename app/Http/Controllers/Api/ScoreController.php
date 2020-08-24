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
    public function leaderboard2() {    
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

    public function leaderboard(){
        $scores = Score::orderBy('id','desc')->get();
        foreach($scores as $score){
            //get all highscores and leadnames
            $score->highscore;
            $score->leadname; 
        }

        return response()->json([
            'success' => true,
            'posts' => $scores
        ]);
    }


    public function del_all_score(){

        Score::whereNotNull('id')->delete();
        return response()->json([
            'success' => true,
            'message' => 'post deleted'
        ]);
    }
}