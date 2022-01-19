<?php

namespace App\Http\Controllers\Api;

//use App\Http\Resources\TopMovie as TopMovieResource;
use App\Http\Resources\TopMovieHistory as TopMovieHistoryResource;
use App\Http\Controllers\Controller;
use App\Models\TopMovieHistory;
use Illuminate\Support\Facades\Artisan;

class TopMoviesController extends Controller
{
    public function get(){
        return response()->json(TopMovieHistoryResource::collection(TopMovieHistory::latest()));
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
