<?php

namespace Database\Factories;

use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;

class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        //$table->string('title');
        //     $table->longText('overview')->nullable();
        //     $table->string('movie-url')->nullable();
        //     $table->integer('length')->nullable();
        //     $table->string('post-url')->nullable();
        //     $table->decimal('vote-average',2,1)->default(1);
        //     $table->date('release-date')->nullable();

        //     $table->foreignId('director_id')->nullable()->constrained('people')->onDelete('cascade');
        return [
            'title'=>$this->faker->text(50),
            'overview'=>$this->faker->text(300),
            'movie_url'=>$this->faker->url(),
            'runtime'=>$this->faker->randomNumber(3),
            'poster_path'=>$this->faker->url(),
            'vote_average'=>$this->faker->randomFloat(1,0,10),
            'release_date'=>$this->faker->dateTimeBetween('-100 years')
        ];
    }
}
