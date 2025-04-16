<?php

namespace Tests\Feature\Ladie;

use App\Models\Ladies;
use App\Repositories\LadieRepository;
use App\Enums\{
    IsAvaliableStatusEnum,
    LadyTypeEnum
};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class LadieRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected $ladieRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->ladieRepository = new LadieRepository(new Ladies());
    }

    public function testCreateLadie()
    {
        // Mock Storage
        Storage::fake('public');

        // Create test ladie data with file uploads
        $ladieData = [
            'serial_number' => 'EMP-001',
            'name' => 'John Doe',
            'phone_number' => '1234567890',
            'dob' => now(),
            'nrc' => '12/345678',
            'nrc_front' => UploadedFile::fake()->image('nrc_front.jpg'),
            'nrc_back' => UploadedFile::fake()->image('nrc_back.jpg'),
            'profile' => UploadedFile::fake()->image('nrc_back.jpg'),
            'address' => '123 Main St',
            'father_name' => 'Father Name',
            'mother_name' => 'Mother Name',
            'join_date' => now(),
            'leave_date' => now(),
            'remark' => 'Test Remark',
            'status' => IsAvaliableStatusEnum::AVALIABLE->value,
            'lady_type' => LadyTypeEnum::NORMAL->value
        ];

        // Call the create method
        $ladie = $this->ladieRepository->create($ladieData);

        // Assert the employee is created
        $this->assertDatabaseHas('ladies', [
            'id' => $ladie->id,
            'name' => 'John Doe',
        ]);

        // Assert the files are stored
        Storage::disk('public')->assertExists($ladie->nrc_front);
        Storage::disk('public')->assertExists($ladie->nrc_back);
        Storage::disk('public')->assertExists($ladie->profile);
    }

    public function testUpdateEmployee()
    {
        // Mock Storage
        Storage::fake('public');

        // Create an ladie for update
        $ladie = Ladies::factory()->create([
            'serial_number' => 'EMP-001',
            'name' => 'John Doe',
            'phone_number' => '1234567890',
            'dob' => now(),
            'nrc' => '12/345678',
            'nrc_front' => UploadedFile::fake()->image('nrc_front.jpg'),
            'nrc_back' => UploadedFile::fake()->image('nrc_back.jpg'),
            'profile' => UploadedFile::fake()->image('nrc_back.jpg'),
            'address' => '123 Main St',
            'father_name' => 'Father Name',
            'mother_name' => 'Mother Name',
            'join_date' => now(),
            'leave_date' => now(),
            'remark' => 'Test Remark',
            'status' => IsAvaliableStatusEnum::AVALIABLE->value,
            'lady_type' => LadyTypeEnum::NORMAL->value
        ]);

        // New data for updating
        $updatedLadieData = [
            'name' => 'Jane Doe', // Update name
            'phone_number' => '0987654321', // Update phone
            'nrc_front' => UploadedFile::fake()->image('nrc_front_updated.jpg'), // New file
            'nrc_back' => UploadedFile::fake()->image('nrc_back_updated.jpg'), // New file
            'profile' => UploadedFile::fake()->image('profile_updated.jpg'), // New file
        ];

        // Call the update method
        $updatedLadie = $this->ladieRepository->update($ladie->id, $updatedLadieData, ['nrc_front', 'nrc_back', 'profile'], 'nrcs');

        // Assert the ladie is updated in the database
        $this->assertDatabaseHas('ladies', [
            'id' => $updatedLadie->id,
            'name' => 'Jane Doe', // Ensure the name is updated
            'phone_number' => '0987654321', // Ensure the phone is updated
        ]);

        // Assert the old files are deleted and the new files are stored
        Storage::disk('public')->assertMissing($ladie->nrc_front); // Assert old file is deleted
        Storage::disk('public')->assertMissing($ladie->nrc_back); // Assert old file is deleted
        Storage::disk('public')->assertMissing($ladie->profile); // Assert old file is deleted

        // Assert the new files exist
        Storage::disk('public')->assertExists($updatedLadie->nrc_front);
        Storage::disk('public')->assertExists($updatedLadie->nrc_back);
        Storage::disk('public')->assertExists($updatedLadie->profile);
    }

    public function testDeleteEmployee()
    {
        $ladie = Ladies::factory()->create();

        // Soft delete the employee and user
        $deletedLadie = $this->ladieRepository->delete($ladie->id);

        // Also assert that the employee itself is deleted
        $this->assertSoftDeleted('ladies', ['id' => $ladie->id]);
    }



    public function testCheckQueryBuilder()
    {
        // Create test data with unique identifiers to ensure uniqueness
        Ladies::factory()->count(10)->create();

        // Assert that the data is created
        $this->assertCount(10, Ladies::all());

        // Mock request query
        $this->mockRequestQuery([
            'order' => 'id',
            'sort' => 'DESC',
            'search' => '',
            'columns' => 'name',
            'page' => 1,
            'per_page' => 5,
        ]);

        // Call the all method
        $results = $this->ladieRepository->all();

        // Assert the results
        $this->assertCount(5, $results->items()); // items() returns the collection of items being paginated
        $this->assertEquals(10, $results->total());
    }

    private function mockRequestQuery(array $query)
    {
        $this->app['request']->query->add($query);

        // Debugging: Output the query parameters
        $this->assertEquals($query, $this->app['request']->query->all());
    }
}
