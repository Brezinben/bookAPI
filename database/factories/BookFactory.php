<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id'=>$this->faker->uuid,
            'title'=>$this->faker->text(),
            'publish_date'=>$this->faker->date(),
            'status'=>$this->faker->randomElement(['disponible', 'en_approvisionnement', 'non_édité']),
            'author_id'=>Author::all()->random()->id,
            'category_id'=>Category::all()->random()->id
        ];
    }
}
