<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TopMovieHistory extends Model
{
    use HasFactory, SoftDeletes;

    public function movies(){
        return $this->hasMany(TopMovie::class,'history_id');
    }
}
