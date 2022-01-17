<?php

namespace Database\Seeders;

use App\Models\Movie;
use App\Models\TopMovie;
use App\Models\TopMovieHistory;
use Illuminate\Database\Seeder;

class TopMovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $history=new TopMovieHistory();
        $history->save();
        $movies=Movie::all();
        foreach($movies as $key => $movie){
            $topmovie=new TopMovie();
            $topmovie->movie_id=$movie->id;
            $topmovie->history_id=$history->id;
            $topmovie->rank=$key+1;
            $topmovie->save();
        }

    }
}
