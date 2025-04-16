<?php

namespace Database\Factories;

use App\Models\Ladies;
use App\Enums\{
    LadyTypeEnum,
    IsAvaliableStatusEnum
};
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class LadiesFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Ladies::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => Str::uuid(),
            'serial_number' => 'SPA-' . $this->faker->unique()->randomNumber(3),
            'name' => $this->faker->name(),
            'phone_number' => $this->faker->unique()->phoneNumber(),
            'dob' => Carbon::now(),
            'nrc' => $this->faker->unique()->bothify('##/#######'),
            'profile' => null,
            'nrc_front' => null,
            'nrc_back' => null,
            'address' => $this->faker->address(),
            'father_name' => $this->faker->name('male'),
            'mother_name' => $this->faker->name('female'),
            'join_date' => Carbon::now(),
            'leave_date' => Carbon::now()->addYears(2),
            'remark' => $this->faker->sentence(),
            'status' => LadyTypeEnum::NORMAL->value,
            'lady_type' => IsAvaliableStatusEnum::AVALIABLE->value,
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ];
    }
}
