<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'card_id'=>$this->faker->numberBetween(1,100),
            'daskription'=>$this->faker->text()
        ];
    }
}
