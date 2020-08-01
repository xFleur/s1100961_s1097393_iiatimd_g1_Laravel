<?php

namespace App;

use App\Score;


use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    //
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function likes(){
        return $this->hasMany(Like::class);
    }
}
