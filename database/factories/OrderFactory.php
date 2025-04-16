<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Room;
use App\Models\Bed;
use App\Enums\{
    PaymentTypeEnum,
    GeneralStatusEnum
};
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $order = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => Str::uuid()->toString(),
            'room_id' => Room::factory(),
            'bed_id' => Bed::factory(),
            'total_amount' => $this->faker->randomFloat(2, 1, 100),
            'pay_amount' => $this->faker->randomFloat(2, 1, 100),
            'refund_amount' => $this->faker->randomFloat(2, 1, 100),
            'remark' => $this->faker->sentence(),
            'status' => GeneralStatusEnum::ACTIVE->value,
            'payment_type' => PaymentTypeEnum::CASH->value,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
