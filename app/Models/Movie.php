<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movie extends Model
{
    use HasFactory, SoftDeletes;

    public function director(){
        return $this->hasOne(Person::class,'id','director_id');
    }

    public function genres(){
        return $this->belongsToMany(Genre::class);
    }
}
