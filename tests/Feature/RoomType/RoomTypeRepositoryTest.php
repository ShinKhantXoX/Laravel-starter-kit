<?php

namespace Tests\Feature;

use App\Models\RoomType;
use App\Repositories\RoomTypeRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Str;

class RoomTypeRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected $roomTypeRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->roomTypeRepository = new RoomTypeRepository(new RoomType());
    }

    public function testCreateRoomType()
    {
        $roomTypeData = [
            'id' => Str::uuid(),
            'label' => 'Deluxe Room',
            'description' => 'A luxurious room with a king-size bed.',
        ];

        $roomType = $this->roomTypeRepository->create($roomTypeData);

        $this->assertDatabaseHas('room_types', [
            'id' => $roomType->id,
            'label' => 'Deluxe Room',
        ]);
    }

    public function testUpdateRoomType()
    {
        $roomType = RoomType::factory()->create([
            'label' => 'Standard Room',
            'description' => 'A basic room with minimal amenities.',
        ]);

        $updatedData = [
            'label' => 'Executive Suite',
            'description' => 'A spacious suite with premium services.',
        ];

        $updatedRoomType = $this->roomTypeRepository->update($roomType->id, $updatedData);

        $this->assertDatabaseHas('room_types', [
            'id' => $updatedRoomType->id,
            'label' => 'Executive Suite',
        ]);
    }

    public function testDeleteRoomType()
    {
        $roomType = RoomType::factory()->create();

        $deletedRoomType = $this->roomTypeRepository->delete($roomType->id);

        $this->assertSoftDeleted('room_types', ['id' => $deletedRoomType->id]);
    }

    public function testIndexRoomTypes()
    {
        RoomType::factory()->count(5)->create();

        $roomTypes = $this->roomTypeRepository->index();

        $this->assertCount(5, $roomTypes);
    }
}
