<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\OrderList;
use App\Models\Menu;
use App\Enums\OrderItemStatusEnum;
use App\Repositories\OrderListRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Str;

class OrderListRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected $orderListRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->orderListRepository = new OrderListRepository(new OrderList());
    }

    public function testCreateOrderList()
    {
        $order = Order::factory()->create();
        $menu = Menu::factory()->create();

        $orderListData = [
            'id' => Str::uuid(),
            'order_id' => $order->id,
            'menu_id' => $menu->id,
            'amount' => 1000,
            'price' => 500,
            'quantity' => 10,
            'name' => 'This is a deluxe room',
            'status' => OrderItemStatusEnum::CONFIRM->value,
        ];

        $orderList = $this->orderListRepository->create($orderListData);

        $this->assertDatabaseHas('order_lists', [
            'id' => $orderList->id,
            'amount' => 1000,
        ]);
    }

    public function testUpdateOrderList()
    {

        $order = Order::factory()->create();
        $menu = Menu::factory()->create();

        $orderList = OrderList::factory()->create([
            'order_id' => $order->id,
            'menu_id' => $menu->id,
            'amount' => 1000,
            'price' => 500,
            'quantity' => 10,
            'name' => 'This is a deluxe room',
            'status' => OrderItemStatusEnum::CONFIRM->value,
        ]);

        $updatedData = [
            'amount' => 2000,
            'price' => 2000,
        ];

        $updatedOrderList = $this->orderListRepository->update($orderList->id, $updatedData);

        $this->assertDatabaseHas('order_lists', [
            'id' => $updatedOrderList->id,
            'amount' => 2000,
            'price' => 2000,
        ]);
    }

    public function testDeleteOrderList()
    {
        $orderList = OrderList::factory()->create();

        $deletedOrderList = $this->orderListRepository->delete($orderList->id);

        $this->assertSoftDeleted('order_lists', ['id' => $deletedOrderList->id]);
    }

    public function testIndexOrderList()
    {
        OrderList::factory()->count(5)->create();

        $orderList = $this->orderListRepository->index();

        $this->assertCount(5, $orderList);
    }
}
