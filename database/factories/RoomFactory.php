<?php

namespace Database\Factories;

use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Enums\IsAvaliableStatusEnum;

class RoomFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Room::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'id' => Str::uuid(),  // Generate UUID
            'room_type_id' => RoomType::factory(),  // Create a RoomType if not provided
            'name' => $this->faker->word,  // Random room name
            'room_number' => $this->faker->unique()->numberBetween(100, 999),  // Random number
            'status' => IsAvaliableStatusEnum::AVALIABLE->value,  // Default status
            'created_at' => now(), // Assuming your auditColumns() has created_by column
            'updated_at' => now(), // Assuming your auditColumns() has updated_by column
            'deleted_at' => null, // Not deleted by default
        ];
    }
}
