<?php

namespace App\Console\Commands;

use App\DataSources\TMDBApi;
use GuzzleHttp\Client;
use App\Helpers\StringHelper;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\Person;
use App\Models\TopMovie;
use App\Models\TopMovieHistory;
use Illuminate\Console\Command;

class TMDBUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tmdb:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Top Movies list from TMDB';

    private $client;
    private $api;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->client=new Client();
        $this->api=new TMDBApi($this->client);
    }

    protected function getMovies($count){
        $topMoviesList=$this->api->getTopRatedMoviesDetailedList($count);

        return array_map(function ($movie){
            $movie['director_id']=$this->api->getDirector($movie['id'])['id'];

            $mov=Movie::firstOrNew(['id'=>$movie['id']]);
            $mov->fill($movie);
            $mov->addGenres($movie['genres']);

            return $mov;
        }, $topMoviesList);
    }

    protected function getDirectors($movies){
        $directorIds=array_unique(array_column($movies, 'director_id'));

        return array_map(function ($id){
            $data=$this->api->getPerson($id);
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
                'rank'=>$key+1
            ]);
            $topMovie->save();
        }
    }

    protected function updateTopMovies($count=10){
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
        $this->updateTopMovies();
        return 0;
    }
}
