<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\TopMovie as TopMovieResource;

class TopMovieHistory extends JsonResource
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
            'last_updated'=>(string)$this->updated_at,
            'movies'=>TopMovieResource::collection($this->whenLoaded('movies'))
        ];
    }
}
