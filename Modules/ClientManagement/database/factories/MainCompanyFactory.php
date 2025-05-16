<?php

namespace Modules\ClientManagement\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\ClientManagement\Models\MainCompany;
use Modules\ClientManagement\Models\Status;
use Illuminate\Support\Str;

class MainCompanyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\ClientManagement\Models\MainCompany::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'client_name' => $this->faker->company(),
            'status' => Status::firstWhere('name', 'active')->id ?? 1,
            'email' => $this->faker->unique()->companyEmail(),
            'mobile' => $this->faker->optional()->phoneNumber(),
            'client_type' => $this->faker->randomElement(['individual', 'company']),
        ];
    }

    public function firstCompany(): static {
        return $this->state(function (array $attributes) {
            return [
                'client_name' => 'Sample Inc.',
                'status' => Status::firstWhere('name', 'active')->id ?? 1,
                'email' => 'contact@sampleinc.com',
                'mobile' => '09111111111',
                'client_type' => 'company',
            ];
        })->hasBranches(5, function (array $attrs, MainCompany $company) {
            $city = $this->faker->city();

            return [
                'branch_name' => $company->client_name . ' - ' . $city . ' Branch',
                'status' => $company->status,
                'email' => Str::slug($city) . ".branch@sampleinc.com",
            ];
        });
    }


}

