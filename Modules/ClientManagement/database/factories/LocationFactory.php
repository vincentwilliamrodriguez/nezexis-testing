<?php

namespace Modules\ClientManagement\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LocationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\ClientManagement\Models\Location::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [];
    }
}

