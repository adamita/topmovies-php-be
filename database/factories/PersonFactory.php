<?php

namespace Database\Factories;

use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'=>$this->faker->name,
            'birthday'=>$this->faker->dateTimeBetween('-90 years'),
            'bio'=>$this->faker->text()
        ];
    }
}
