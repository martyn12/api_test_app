<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $hours = rand(1, 12);
        $hourlyPayment = 200;
        return [
            'employee_id' => function () {
                return Employee::inRandomOrder()->first()->id;
            },
            'hours' => $hours,
            'payment' => $hours * $hourlyPayment
        ];
    }
}
