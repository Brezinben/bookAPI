<?php

namespace Database\Factories;

use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

class AuthorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Author::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id'=> $this->faker->uuid,
            'first_name'=>$this->faker->firstName,
            'last_name'=>$this->faker->lastName,
            'birth_date'=>$this->faker->date(),
            'death_date'=>$this->faker->date(),
        ];
    }
}
