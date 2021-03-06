<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TopMovieHistory extends Model
{
    use HasFactory, SoftDeletes;

    public static function latestTopMoviesList(){
        return self::latest()
            ->with('movies', function($topMovie){
                $topMovie
                ->with('movie', function($movie){
                    $movie->with('director','genres');
                })
                ->orderBy('rank');
            })
            ->get();
    }

    public function movies(){
        return $this->hasMany(TopMovie::class,'history_id');
    }
}
