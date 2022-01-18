<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Person extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable=[
        'id',
        'name',
        'birthday',
        'biography'
    ];

    public function movies(){
        return $this->hasMany(Movie::class,'director_id','id');
    }
}
