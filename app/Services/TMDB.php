<?php

namespace App\Services;

use App\Helpers\StringHelper;
use Illuminate\Http\Response;
use GuzzleHttp\Client;

class TMDB{
    const WEB_URL='www.themoviedb.org';
    const API_URL='https://api.themoviedb.org/3';

    private Client $client;
    private string $key, $url, $lang;

    public function __construct(Client $client, string $key, string $apiUrl='', string $lang='en-EN')
    {
        $this->client = $client;
        $this->key = $key;
        $this->url = empty($apiUrl) ? static::API_URL : $apiUrl;
        $this->lang = $lang;
    }

    public function getTopRatedMoviesDetailedList($count=20){
        $topMoviesList=$this->getTopRatedMoviesList($count);

        return array_map(function ($topMovie){
            $id=(int)$topMovie['id'];

            $movie=$this->getMovie($id);
            $movie['director_id']=$this->getDirector($id)['id'];
            $movie['movie_url']=$this->webUrl($movie);

            return $movie;
        }, $topMoviesList);
    }

    public function getTopRatedMoviesList($count = 20){
        if($count<=0)
            return [];

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
            'api_key'=>$this->key
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

    private function webUrl(array $attr){
        if(!array_key_exists('title',$attr) || !array_key_exists('id',$attr))
            return '';

        $url=StringHelper::clean($attr['title']);
        return static::WEB_URL . "/movie/{$attr['id']}-{$url}";
    }
}
