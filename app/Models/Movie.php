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

    protected $tempGenres=[];

    public function director(){
        return $this->hasOne(Person::class,'id','director_id');
    }

    public function genres(){
        return $this->morphToMany(Genre::class,'genreable')->withTimestamps();
    }

    public function addGenres($genres){
        foreach($genres as $genre){
            $gen=Genre::firstOrNew(['id'=>$genre['id']]);
            $gen->fill($genre);
            $gen->save();
        }

        $this->tempGenres=array_column($genres,'id');
    }

    public function syncGenres(){
        $this->genres()->sync($this->tempGenres);
    }
}
