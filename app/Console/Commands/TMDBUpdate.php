<?php

namespace App\Console\Commands;

use App\Models\Movie;
use App\Models\Person;
use App\Models\TopMovie;
use App\Models\TopMovieHistory;
use App\Services\TMDB;
use Illuminate\Console\Command;

class TMDBUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tmdb:sync {count=210}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Top Movies list from TMDB';

    protected function getMovies($count){
        $api=resolve(TMDB::class);
        $topMoviesList=$api->getTopRatedMoviesDetailedList($count);

        return array_map(function ($movie) use ($api){
            $movie['director_id']=$api->getDirector($movie['id'])['id'];

            $mov=Movie::firstOrNew(['id'=>$movie['id']]);
            $mov->fill($movie);
            $mov->addGenres($movie['genres']);

            return $mov;
        }, $topMoviesList);
    }

    protected function getDirectors($movies){
        $directorIds=array_unique(array_column($movies, 'director_id'));

        $api=resolve(TMDB::class);
        return array_map(function ($id) use ($api){
            $data=$api->getPerson($id);
            $person=Person::firstOrNew(['id'=>$data['id']]);
            $person->fill($data);
            return $person;
        }, $directorIds);
    }

    protected function saveTopMovies($movies, $directors){
        $history=TopMovieHistory::create();

        foreach($directors as $dir){
            $dir->save();
        }

        foreach($movies as $key => $movie){
            $movie->save();
            $movie->syncGenres();
            $topMovie=new TopMovie([
                'movie_id'=>$movie->id,
                'history_id'=>$history->id,
                'vote_average'=>$movie->vote_average,
                'vote_count'=>$movie->vote_count,
                'rank'=>$key+1
            ]);
            $topMovie->save();
        }
    }

    protected function updateTopMovies($count=20){
        $movies=$this->getMovies($count);
        $directors=$this->getDirectors($movies);

        $this->saveTopMovies($movies, $directors);
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $count=$this->argument('count');
        $this->updateTopMovies($count);
        return true;
    }
}
