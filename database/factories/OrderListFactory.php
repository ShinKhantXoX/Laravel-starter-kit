<?php

namespace Database\Factories;

use App\Models\{
    OrderList,
    Order,
    Menu
};
use App\Enums\OrderItemStatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderList>
 */
class OrderListFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $orderList = OrderList::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => Str::uuid()->toString(),
            'order_id' => Order::factory(),
            'menu_id' => Menu::factory(),
            'amount' => $this->faker->randomFloat(2, 1, 100),
            'price' => $this->faker->randomFloat(2, 1, 100),
            'quantity' => $this->faker->randomFloat(2, 1, 100),
            'name' => $this->faker->sentence(),
            'status' => OrderItemStatusEnum::CONFIRM->value,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
