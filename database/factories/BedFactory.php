<?php

namespace Database\Factories;

use App\Models\Bed;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Enums\IsAvaliableStatusEnum;

class BedFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Bed::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'id' => Str::uuid(),  // Generate UUID
            'room_id' => Room::factory(),  // Create a RoomType if not provided
            'label' => $this->faker->word,  // Random room name
            'bed_number' => $this->faker->word,  // Random number
            'status' => IsAvaliableStatusEnum::AVALIABLE->value,  // Default status
            'created_at' => now(), // Assuming your auditColumns() has created_by column
            'updated_at' => now(), // Assuming your auditColumns() has updated_by column
            'deleted_at' => null, // Not deleted by default
        ];
    }
}
