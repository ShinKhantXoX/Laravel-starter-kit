<?php

namespace Tests\Feature;

use App\Models\Room;
use App\Models\RoomType;
use App\Enums\IsAvaliableStatusEnum;
use App\Repositories\RoomRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Str;

class RoomRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected $roomRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->roomRepository = new RoomRepository(new Room());
    }

    public function testCreateRoom()
    {
        $roomType = RoomType::factory()->create();

        $roomData = [
            'id' => Str::uuid(),
            'room_type_id' => $roomType->id,
            'name' => 'Deluxe Room',
            'room_number' => '101',
            'status' => IsAvaliableStatusEnum::AVALIABLE->value,
        ];

        $room = $this->roomRepository->create($roomData);

        $this->assertDatabaseHas('rooms', [
            'id' => $room->id,
            'name' => 'Deluxe Room',
        ]);
    }

    public function testUpdateRoom()
    {
        $room = Room::factory()->create([
            'name' => 'Standard Room',
            'room_number' => '1002',
        ]);

        $updatedData = [
            'name' => 'Executive Suite',
            'room_number' => '003',
        ];

        $updatedRoom = $this->roomRepository->update($room->id, $updatedData);

        $this->assertDatabaseHas('rooms', [
            'id' => $updatedRoom->id,
            'name' => 'Executive Suite',
        ]);
    }

    public function testDeleteRoom()
    {
        $room = Room::factory()->create();

        $deletedRoom = $this->roomRepository->delete($room->id);

        $this->assertSoftDeleted('rooms', ['id' => $deletedRoom->id]);
    }

    public function testIndexRoom()
    {
        Room::factory()->count(5)->create();

        $room = $this->roomRepository->index();

        $this->assertCount(5, $room);
    }
}
