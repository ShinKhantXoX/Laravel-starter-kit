<?php

namespace Tests\Feature\User;

use Tests\TestCase;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Mockery;

class UserRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected $userRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\PermissionSeeder::class);
        $this->seed(\Database\Seeders\RoleSeeder::class);
        $this->userRepository = new UserRepository(new User());
    }

    public function testCreateUser()
    {
        $userData = [
            'username' => 'test',
            'email' => 'test@gmail.com',
            'phone' => '99982393',
            'password' => 'password123',
            'role' => 'SUPER_ADMIN',
            'status' => 'ACTIVE'
        ];

        $user = $this->userRepository->create($userData);

        $this->assertDatabaseHas('users', [
            'username' => 'test',
            'email' => 'test@gmail.com'
        ]);

        $this->assertTrue(Hash::check('password123', $user->password));
    }

    public function testUpdateUser()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password123')
        ]);

        $userData = [
            'username' => 'updatedname',
            'email' => 'updatedemail@gmail.com',
            'password' => 'newpassword123',
            'role' => 'MANAGER',
            'status' => 'PENDING'
        ];

        $updatedUser = $this->userRepository->update($user->id, $userData);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'username' => 'updatedname',
            'email' => 'updatedemail@gmail.com'
        ]);

        $this->assertTrue(Hash::check('newpassword123', $updatedUser->password));
    }

    public function testDeleteUser()
    {
        $user = User::factory()->create();

        $deletedUser = $this->userRepository->delete($user->id);

        $this->assertSoftDeleted('users', ['id' => $user->id]);
    }

    public function testCheckEmailExists()
    {
        $user = User::factory()->create(['email' => 'testemail@gmail.com']);

        $this->assertTrue($this->userRepository->checkEmailExists('testemail@gmail.com'));
        $this->assertFalse($this->userRepository->checkEmailExists('nonexistent@gmail.com'));
    }

    public function testCheckQueryBuilder()
    {
        // Create test data with unique identifiers to ensure uniqueness
        User::factory()->count(10)->create();

        // Assert that the data is created
        $this->assertCount(10, User::all());

        // Mock request query
        $this->mockRequestQuery([
            'order' => 'id',
            'sort' => 'DESC',
            'search' => 'TestUser',
            'columns' => 'username,email',
            'page' => 1,
            'per_page' => 5,
        ]);

        // Call the all method
        $results = $this->userRepository->all();

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
