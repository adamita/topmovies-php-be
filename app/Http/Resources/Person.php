<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Person extends JsonResource
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
            'tmdb_id'=>$this->id,
            'name'=>$this->name,
            'biography'=>$this->biography,
            'date_of_birth'=>$this->birthday
        ];
    }
}
