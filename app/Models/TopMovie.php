<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TopMovie extends Model
{
    use HasFactory, SoftDeletes;

    public function movie(){
        return $this->hasOne(Movie::class);
    }

    public function topMovieHistory(){
        return $this->hasOne(TopMovieHistory::class);
    }
}
