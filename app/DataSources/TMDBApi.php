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

    public function getTopRatedMoviesList($count = 20){
        $resp= $this->getTopRatedMoviesListByPage();
        $list=[];
        $page=1;
        $total=0;
        do
        {
            $resp =  $this->getTopRatedMoviesListByPage($page);
            if ($resp){
                $list=array_merge($list, $resp['results']);
                $total=(int)$resp['total_results'];
            }
            $page++;
        }
        while (count($list) < $count && count($list) < $total);
        return array_slice($list,0,$count);
    }

    public function getTopRatedMoviesListByPage($page=1){
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
