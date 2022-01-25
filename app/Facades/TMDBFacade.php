<?php

namespace App\Facades;

//use App\Contracts\TMDBContract;
use Illuminate\Support\Facades\Facade;

/**
 * @method static array getTopRatedMoviesDetailedList($count=20)
 * @method static array getTopRatedMoviesList($count = 20)
 * @method static array getTopRatedMoviesListByPage($page=1)
 * @method static array getMovie($id)
 * @method static array getMovieCredits($id)
 * @method static array getDirector($movieId)
 * @method static array getPerson($id)
 */
class TMDBFacade extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'App\Contracts\TMDBContract';
    }
}
