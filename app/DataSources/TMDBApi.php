<?php

namespace App\DataSources;

use Carbon\Carbon;
use GuzzleHttp\Client;
//use GuzzleHttp\Psr7\Request;
use Illuminate\Http\Response;

class TMDBApi
{
    const API_URL='https://api.themoviedb.org/3';

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->config = config('services.tmdb');
        $this->url = empty($this->config['url']) ? static::API_URL : $this->config['url'];
        $this->lang = 'en-EN';
    }

    public function getTopRatedMoviesList($page=1){
        $res = $this->client->get("{$this->url}/movie/top_rated", [
            'query'=>[
                'api_key'=>$this->config['key'],
                'lang'=>$this->lang,
                'page'=>$page
            ]
        ]);

        if ($res->getStatusCode() !== Response::HTTP_OK) {
            return false;
        }

        return json_decode($res->getBody()->getContents(), true);
    }

    public function getMovieDetails(){

    }

    public function getMovieCredits(){

    }

    public function getPerson(){

    }
}
