<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Operational\Customer;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Operational\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Customer::class;
     
    public function definition()
    {
        return [
            "name" => $this->faker->name(),
            "contact" => $this->faker->unique()->phoneNumber(),
            "address" => $this->faker->address(),
        ];
    }
}
