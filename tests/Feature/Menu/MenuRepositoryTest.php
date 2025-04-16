<?php

namespace Tests\Feature\Employee;

use App\Models\Menu;
use App\Models\MenuCategory;
use App\Repositories\MenuRepository;
use App\Enums\IsAvaliableStatusEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Illuminate\Support\Str;

class MenuRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected $menuRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->menuRepository = new MenuRepository(new Menu());
    }

    public function testCreateMenu()
    {
        // Mock Storage
        Storage::fake('public');

        // Create a test Menu Category
        $menuCategory = MenuCategory::factory()->create();

        // Create test employee data with file uploads
        $menuData = [
            'menu_category_id' => $menuCategory->id,
            'name' => 'John Doe',
            'price' => 10000,
            'photo' => UploadedFile::fake()->image('photo.jpg'),
            'description' => 'Testing',
            'status' => IsAvaliableStatusEnum::AVALIABLE->value
        ];

        // Call the create method
        $menu = $this->menuRepository->create($menuData);

        // Assert the employee is created
        $this->assertDatabaseHas('menus', [
            'id' => $menu->id,
            'name' => 'John Doe',
        ]);

        // Assert the files are stored
        Storage::disk('public')->assertExists($menu->photo);
    }

    public function testUpdateMenu()
    {
        // Mock Storage
        Storage::fake('public');

        // Create a test user
        $menuCategory = MenuCategory::factory()->create();

        // Create test employee data with file uploads
        $menu = Menu::Factory()->create([
            'menu_category_id' => $menuCategory->id,
            'name' => 'John Doe',
            'price' => 10000,
            'photo' => UploadedFile::fake()->image('photo.jpg'),
            'description' => 'Testing',
            'status' => IsAvaliableStatusEnum::AVALIABLE->value
        ]);

        // New data for updating
        $updatedMenuData = [
            'name' => 'Jane Doe', // Update name
            'price' => 44444, // Update phone
            'photo' => UploadedFile::fake()->image('photo.jpg'), // New file
        ];

        // Call the update method
        $updatedMenu = $this->menuRepository->update($menu->id, $updatedMenuData, ['photo'], 'photo');

        // Assert the employee is updated in the database
        $this->assertDatabaseHas('menus', [
            'id' => $updatedMenu->id,
            'name' => 'Jane Doe', // Ensure the name is updated
            'price' => 44444, // Ensure the phone is updated
        ]);

        // Assert the old files are deleted and the new files are stored
        Storage::disk('public')->assertMissing($menu->photo); // Assert old file is deleted

        // Assert the new files exist
        Storage::disk('public')->assertExists($updatedMenu->photo);
    }

    public function testDeleteMenu()
    {
        $menu = Menu::factory()->create();

        $deletedMenu = $this->menuRepository->delete($menu->id);

        $this->assertSoftDeleted('menus', ['id' => $deletedMenu->id]);
    }



    public function testCheckQueryBuilder()
    {
        // Create test data with unique identifiers to ensure uniqueness
        Menu::factory()->count(10)->create();

        // Assert that the data is created
        $this->assertCount(10, Menu::all());

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
        $results = $this->menuRepository->all();

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
