<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movie extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable=[
        'id',
        'title',
        'overview',
        'movie_url',
        'runtime',
        'poster_path',
        'vote_average',
        'release_date',
        'director_id'
    ];

    private static function clean($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.

        return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
     }

    public static function getMovie($movie){
        $url=Movie::clean($movie['title']);
        $data=[
            'id'=>$movie['id'],
            'title'=>$movie['title'],
            'overview'=>$movie['overview'],
            'movie_url'=>"www.themoviedb.org/movie/{$movie['id']}-{$url}",
            'length'=>$movie['runtime'],
            'post_url'=>$movie['poster_path'],
            'vote_average'=>$movie['vote_average'],
            'release_date'=>$movie['release_date'],
            'director_id'=>$movie['director_id']
        ];
        return new Movie($data);
    }

    public function director(){
        return $this->hasOne(Person::class,'id','director_id');
    }

    public function genres(){
        return $this->belongsToMany(Genre::class);
    }
}
