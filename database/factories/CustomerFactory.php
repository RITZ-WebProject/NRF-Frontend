<?php

namespace Database\Factories;

use App\Http\Controllers\CustomersController;
use App\Models\Customers;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Customers::class;
    public function definition()
    {
        return [
            'customer_name' => $this->faker->name(),
            'phone_primary' => $this->faker->phoneNumber(),
            'email' => $this->faker->email(),
            'password' => $this->faker->password()
        ];
    }
}
