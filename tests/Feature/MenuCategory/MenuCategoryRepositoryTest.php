<?php

namespace Tests\Feature;

use App\Models\MenuCategory;
use App\Repositories\MenuCategoryRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Str;

class MenuCategoryRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected $menuCategoryRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->menuCategoryRepository = new MenuCategoryRepository(new MenuCategory());
    }

    public function testCreateMenuCategory()
    {
        $menuCategoryData = [
            'id' => Str::uuid(),
            'label' => 'Deluxe Room',
            'description' => 'A luxurious room with a king-size bed.',
        ];

        $menuCategory = $this->menuCategoryRepository->create($menuCategoryData);

        $this->assertDatabaseHas('menu_categories', [
            'id' => $menuCategory->id,
            'label' => 'Deluxe Room',
        ]);
    }

    public function testUpdateMenuCategory()
    {
        $menuCategory = MenuCategory::factory()->create([
            'label' => 'Standard Room',
            'description' => 'A basic room with minimal amenities.',
        ]);

        $updatedData = [
            'label' => 'Executive Suite',
            'description' => 'A spacious suite with premium services.',
        ];

        $updatedMenuCategory = $this->menuCategoryRepository->update($menuCategory->id, $updatedData);

        $this->assertDatabaseHas('menu_categories', [
            'id' => $updatedMenuCategory->id,
            'label' => 'Executive Suite',
        ]);
    }

    public function testDeleteMenuCategory()
    {
        $menuCategory = MenuCategory::factory()->create();

        $deletedMenuCategory = $this->menuCategoryRepository->delete($menuCategory->id);

        $this->assertSoftDeleted('menu_categories', ['id' => $deletedMenuCategory->id]);
    }

    public function testIndexMenuCategory()
    {
        MenuCategory::factory()->count(5)->create();

        $menuCategory = $this->menuCategoryRepository->index();

        $this->assertCount(5, $menuCategory);
    }
}
