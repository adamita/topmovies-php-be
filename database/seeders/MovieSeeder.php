<?php

namespace Database\Seeders;

use App\Models\Movie;
use App\Models\Person;
use Illuminate\Database\Seeder;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $people=Person::all();

        $count=(int)$this->command->ask('How many movies do you like?',210);

        Movie::factory($count)->make()->each(function ($movie) use ($people){
            $movie->director_id = $people->random()->id;
            $movie->save();
        });
    }
}
