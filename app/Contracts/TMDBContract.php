<?php

namespace App\Contracts;

interface TMDBContract
{
    public function getTopRatedMoviesDetailedList($count=20):array;

    public function getTopRatedMoviesList($count = 20):array;

    public function getTopRatedMoviesListByPage($page=1):array;

    public function getMovie($id):array;

    public function getMovieCredits($id):array;

    public function getDirector($movieId):array;

    public function getPerson($id):array;
}
