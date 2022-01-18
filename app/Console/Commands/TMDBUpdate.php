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
    }

    protected function updateTopMovies(){
        $count=10;
        $client=new Client();
        $api=new TMDBApi($client);

        $topMoviesList=$api->getTopRatedMoviesList($count);
        $movies=array_map(function ($movie) use ($api){
            $id=(int)$movie['id'];
            $movie=$api->getMovie($id);
            $movie['director_id']=$api->getDirector($id)['id'];
            $url=StringHelper::clean($movie['title']);
            $movie['movie_url']="www.themoviedb.org/movie/{$movie['id']}-{$url}";
            $mov=Movie::firstOrNew(['id'=>$movie['id']]);
            $mov->fill($movie);

            foreach($movie['genres'] as $genre){
                $gen=Genre::firstOrNew(['id'=>$genre['id']]);
                $gen->fill($genre);
                $gen->save();
            }
            $mov->genres()->sync(array_column($movie['genres'],'id'));

            return $mov;
        }, $topMoviesList);

        $directorIds=array_unique(array_column($movies, 'director_id'));
        $directors=array_map(function ($id) use ($api){
            $data=$api->getPerson($id);
            $person=Person::firstOrNew(['id'=>$data['id']]);
            $person->fill($data);
            return $person;
        }, $directorIds);

        $history=TopMovieHistory::create();
        foreach($directors as $dir){
            $dir->save();
        }

        foreach($movies as $key => $movie){
            $movie->save();
            $topMovie=new TopMovie([
                'movie_id'=>$movie->id,
                'history_id'=>$history->id,
                'rank'=>$key+1
            ]);
            $topMovie->save();
        }
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
