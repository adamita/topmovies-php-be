<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Movie as MovieResource;

class TopMovie extends JsonResource
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
            'rank'=>$this->rank,
            'vote_count'=>$this->vote_count,
            'vote_average'=>$this->vote_average,
            $this->merge(new MovieResource($this->whenLoaded('movie')))
        ];
    }
}
