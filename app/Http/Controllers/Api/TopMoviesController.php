<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TopMovieHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class TopMoviesController extends Controller
{
    public function get()
    {
        if(TopMovieHistory::take(1)->pluck('id')->count()==0)
            Artisan::call('tmdb:sync');

        $history=TopMovieHistory::orderBy(TopMovieHistory::CREATED_AT,'desc')
            ->with('movies', function($topMovie){
                $topMovie
                ->with('movie', function($movie){
                    $movie->with('director','genres');
                })
                ->orderBy('rank');
            })
            ->take(1)
            ->get();
        return response()->json($history);
    }

    public function test(){
        return response()->json(['test'=>'OK']);
    }

    public function index()
    {
        return redirect()->action([self::class,'test']);
    }

    public function update()
    {
        Artisan::call('tmdb:sync');
        return response()->json(['updated']);
    }
}
