<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Comment;

class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'sentence' => $this->faker->sentence(),
            'item_id' => $this->faker->numberBetween(1,10),
            'account_id' => $this->faker->numberBetween(1,3),
        ];
    }
}
