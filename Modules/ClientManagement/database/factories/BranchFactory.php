<?php

namespace Modules\ClientManagement\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\ClientManagement\Models\Status;

class BranchFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\ClientManagement\Models\Branch::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'branch_name' => $this->faker->company . ' - ' . $this->faker->word() . ' Branch',
            'status' => Status::firstWhere('name', 'active')->id ?? 1,
            'email' => $this->faker->unique()->companyEmail(),
            'mobile' => $this->faker->optional()->phoneNumber(),
        ];
    }
}

