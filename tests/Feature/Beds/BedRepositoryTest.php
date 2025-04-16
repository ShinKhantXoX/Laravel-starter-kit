<?php

namespace Tests\Feature;

use App\Models\Bed;
use App\Models\Room;
use App\Enums\IsAvaliableStatusEnum;
use App\Repositories\BedRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Str;

class BedRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected $bedRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->bedRepository = new BedRepository(new Bed());
    }

    public function testCreateBed()
    {
        $room = Room::factory()->create();

        $bedData = [
            'id' => Str::uuid(),
            'room_id' => $room->id,
            'label' => 'Deluxe Room',
            'bed_number' => '101',
            'remark' => 'This is a deluxe room',
            'status' => IsAvaliableStatusEnum::AVALIABLE->value,
        ];

        $bed = $this->bedRepository->create($bedData);

        $this->assertDatabaseHas('beds', [
            'id' => $bed->id,
            'label' => 'Deluxe Room',
        ]);
    }

    public function testUpdateBed()
    {
        $bed = Bed::factory()->create([
            'label' => 'Standard Room',
            'bed_number' => '1002',
        ]);

        $updatedData = [
            'label' => 'Executive Suite',
            'room_number' => '003',
        ];

        $updatedBed = $this->bedRepository->update($bed->id, $updatedData);

        $this->assertDatabaseHas('beds', [
            'id' => $updatedBed->id,
            'label' => 'Executive Suite',
        ]);
    }

    public function testDeleteBed()
    {
        $bed = Bed::factory()->create();

        $deletedBed = $this->bedRepository->delete($bed->id);

        $this->assertSoftDeleted('beds', ['id' => $deletedBed->id]);
    }

    public function testIndexRoom()
    {
        Bed::factory()->count(5)->create();

        $bed = $this->bedRepository->index();

        $this->assertCount(5, $bed);
    }
}
