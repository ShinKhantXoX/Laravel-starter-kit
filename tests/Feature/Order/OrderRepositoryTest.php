<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Room;
use App\Models\Bed;
use App\Enums\{
    PaymentTypeEnum,
    GeneralStatusEnum
};
use App\Repositories\OrderRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Str;

class OrderRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected $orderRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->orderRepository = new OrderRepository(new Order());
    }

    public function testCreateOrder()
    {
        $room = Room::factory()->create();
        $bed = Bed::factory()->create();

        $orderData = [
            'id' => Str::uuid(),
            'room_id' => $room->id,
            'bed_id' => $bed->id,
            'total_amount' => 1000,
            'pay_amount' => 500,
            'refund_amount' => 500,
            'remark' => 'This is a deluxe room',
            'status' => GeneralStatusEnum::ACTIVE->value,
            'payment_type' => PaymentTypeEnum::CASH->value,
        ];

        $order = $this->orderRepository->create($orderData);

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'total_amount' => 1000,
        ]);
    }

    public function testUpdateOrder()
    {

        $room = Room::factory()->create();
        $bed = Bed::factory()->create();

        $order = Order::factory()->create([
            'room_id' => $room->id,
            'bed_id' => $bed->id,
            'total_amount' => 1000,
            'pay_amount' => 500,
            'refund_amount' => 500,
            'remark' => 'This is a deluxe room',
            'status' => GeneralStatusEnum::ACTIVE->value,
            'payment_type' => PaymentTypeEnum::CASH->value,
        ]);

        $updatedData = [
            'total_amount' => 2000,
            'pay_amount' => 2000,
        ];

        $updatedOrder = $this->orderRepository->update($order->id, $updatedData);

        $this->assertDatabaseHas('orders', [
            'id' => $updatedOrder->id,
            'total_amount' => 2000,
            'pay_amount' => 2000,
        ]);
    }

    public function testDeleteOrder()
    {
        $order = Order::factory()->create();

        $deletedOrder = $this->orderRepository->delete($order->id);

        $this->assertSoftDeleted('orders', ['id' => $deletedOrder->id]);
    }

    public function testIndexOrder()
    {
        Order::factory()->count(5)->create();

        $order = $this->orderRepository->index();

        $this->assertCount(5, $order);
    }
}
