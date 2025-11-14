<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Like;

class LikeFactory extends Factory
{
    protected $model = Like::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'account_id' => $this->faker->numberBetween(1,3),
            'item_id' => $this->faker->numberBetween(1,10),
        ];
    }
}
