<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DeskListFactory extends Factory
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
            'desk_id'=>$this->faker->numberBetween(1,100),

        ];
    }
}
