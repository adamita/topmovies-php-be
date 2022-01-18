<?php

namespace App\Http\Controllers\Api;

use App\DataSources\TMDBApi;
use App\Http\Controllers\Controller;
use App\Helpers\StringHelper;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\Person;
use App\Models\TopMovie;
use App\Models\TopMovieHistory;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class TopMoviesController extends Controller
{
    public function get()
    {
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

        return $movies;
    }

    public function getDirectors(){

    }

    public function getGenres(){

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $client=new Client();
        $api=new TMDBApi($client);
        $list=$api->getPerson(1);
        return response()->json($list);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
