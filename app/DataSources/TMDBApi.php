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
        return $this->get('/movie/top_rated',[
            'lang'=>$this->lang,
            'page'=>$page
        ]);
    }

    public function getMovie($id){
        return $this->get("/movie/{$id}");
    }

    public function getMovieCredits($id){
        return $this->get("/movie/{$id}/credits");
    }

    public function getDirector($movieId)
    {
        $credit= $this->getMovieCredits($movieId);
        $directorId=array_search('Director', array_column($credit['crew'], 'job'));
        return $credit['crew'][$directorId];
    }

    public function getPerson($id){
        return $this->get("/person/{$id}");
    }

    private function get($action, $query=null){
        $queryString=[
            'api_key'=>$this->config['key']
        ];

        if(isset($query)){
            $queryString=array_merge($queryString,$query);
        }

        $res = $this->client->get("{$this->url}{$action}", [
            'query'=>$queryString
        ]);

        if ($res->getStatusCode() !== Response::HTTP_OK) {
            return false;
        }

        return json_decode($res->getBody()->getContents(), true);
    }
}
