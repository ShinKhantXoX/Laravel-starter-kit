<?php

namespace Tests\Feature\Employee;

use App\Models\Employee;
use App\Models\User;
use App\Repositories\EmployeeRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class EmployeeRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected $employeeRepository;

    public function setUp(): void
    {
        parent::setUp();
        $this->employeeRepository = new EmployeeRepository(new Employee());
    }

    public function testCreateEmployee()
    {
        // Mock Storage
        Storage::fake('public');

        // Create a test user
        $user = User::factory()->create();

        // Create test employee data with file uploads
        $employeeData = [
            'user_id' => $user->id,
            'employee_no' => 'EMP-001',
            'name' => 'John Doe',
            'phone' => '1234567890',
            'date' => now(),
            'nrc' => '12/345678',
            'nrc_front' => UploadedFile::fake()->image('nrc_front.jpg'),
            'nrc_back' => UploadedFile::fake()->image('nrc_back.jpg'),
            'address' => '123 Main St',
            'father_name' => 'Father Name',
            'mother_name' => 'Mother Name',
            'join_date' => now(),
            'leave_date' => now(),
            'remark' => 'Test Remark',
        ];

        // Call the create method
        $employee = $this->employeeRepository->create($employeeData);

        // Assert the employee is created
        $this->assertDatabaseHas('employees', [
            'id' => $employee->id,
            'name' => 'John Doe',
        ]);

        // Assert the files are stored
        Storage::disk('public')->assertExists($employee->nrc_front);
        Storage::disk('public')->assertExists($employee->nrc_back);
    }

    public function testUpdateEmployee()
    {
        // Mock Storage
        Storage::fake('public');

        // Create a test user
        $user = User::factory()->create();

        // Create an employee for update
        $employee = Employee::factory()->create([
            'user_id' => $user->id,
            'employee_no' => 'EMP-001',
            'name' => 'John Doe',
            'phone' => '1234567890',
            'date' => now(),
            'nrc' => '12/345678',
            'nrc_front' => UploadedFile::fake()->image('nrc_front.jpg'),
            'nrc_back' => UploadedFile::fake()->image('nrc_back.jpg'),
            'address' => '123 Main St',
            'father_name' => 'Father Name',
            'mother_name' => 'Mother Name',
            'join_date' => now(),
            'leave_date' => now(),
            'remark' => 'Test Remark',
        ]);

        // New data for updating
        $updatedEmployeeData = [
            'name' => 'Jane Doe', // Update name
            'phone' => '0987654321', // Update phone
            'nrc_front' => UploadedFile::fake()->image('nrc_front_updated.jpg'), // New file
            'nrc_back' => UploadedFile::fake()->image('nrc_back_updated.jpg'), // New file
        ];

        // Call the update method
        $updatedEmployee = $this->employeeRepository->update($employee->id, $updatedEmployeeData, ['nrc_front', 'nrc_back'], 'nrcs');

        // Assert the employee is updated in the database
        $this->assertDatabaseHas('employees', [
            'id' => $updatedEmployee->id,
            'name' => 'Jane Doe', // Ensure the name is updated
            'phone' => '0987654321', // Ensure the phone is updated
        ]);

        // Assert the old files are deleted and the new files are stored
        Storage::disk('public')->assertMissing($employee->nrc_front); // Assert old file is deleted
        Storage::disk('public')->assertMissing($employee->nrc_back); // Assert old file is deleted

        // Assert the new files exist
        Storage::disk('public')->assertExists($updatedEmployee->nrc_front);
        Storage::disk('public')->assertExists($updatedEmployee->nrc_back);
    }

    public function testDeleteEmployee()
    {
        $employee = Employee::factory()->create();

        // Eager load the user relationship
        $employee->load('user');

        // Soft delete the employee and user
        $deletedEmployee = $this->employeeRepository->delete($employee->id);

        // Ensure the associated user is soft deleted
        $this->assertSoftDeleted('users', ['id' => $employee->user->id]);

        // Also assert that the employee itself is deleted
        $this->assertSoftDeleted('employees', ['id' => $employee->id]);
    }



    public function testCheckQueryBuilder()
    {
        // Create test data with unique identifiers to ensure uniqueness
        Employee::factory()->count(10)->create();

        // Assert that the data is created
        $this->assertCount(10, Employee::all());

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
        $results = $this->employeeRepository->all();

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
