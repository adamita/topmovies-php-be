<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Person as PersonResource;
use App\Http\Resources\Genre as GenreResource;

class Movie extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'title'=>$this->title,
            'length'=>$this->runtime,
            'genres'=>GenreResource::collection($this->whenLoaded('genres')),
            'release_date'=>$this->release_date,
            'overview'=>$this->overview,
            'poster_url'=>$this->poster_path,
            'tmdb_id'=>$this->id,
            'tmdb_vote average'=>$this->vote_average,
            //'tmbd_vote_count'=>$this->vote_count,
            'tmdb_url'=>$this->movie_url,
            'director'=>new PersonResource($this->whenLoaded('director'))
        ];
    }
}
