<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\User;
use App\Enums\{
    EmployeeTypeEnum,
    GeneralStatusEnum
};
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Employee::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => Str::uuid(),
            'user_id' => User::factory(), // Creates a new User if none exist
            'employee_no' => 'EMP-' . $this->faker->unique()->randomNumber(3),
            'name' => $this->faker->name(),
            'phone' => $this->faker->unique()->phoneNumber(),
            'date' => Carbon::now(),
            'nrc' => $this->faker->unique()->bothify('##/#######'),
            'nrc_front' => null,
            'nrc_back' => null,
            'address' => $this->faker->address(),
            'father_name' => $this->faker->name('male'),
            'mother_name' => $this->faker->name('female'),
            'join_date' => Carbon::now(),
            'leave_date' => Carbon::now()->addYears(2),
            'remark' => $this->faker->sentence(),
            'status' => GeneralStatusEnum::ACTIVE->value,
            'employee_type' => EmployeeTypeEnum::LADY->value,
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ];
    }
}
