<?php

namespace App;

use App\Score;


use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    //
    // public function user(){
    //     return $this->belongsTo(User::class);
    // }

    public static function deleteData($id){
        DB::table('users')->where('id', '=', $id)->delete();
      }

}
