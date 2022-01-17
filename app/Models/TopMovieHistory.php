<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TopMovieHistory extends Model
{
    use HasFactory, SoftDeletes;

    public function topMovie(){
        return $this->hasOne(TopMovie::class,'history_id');
    }
}
