<?php

namespace App\Repositories;

use App\Models\Employee;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class EmployeeRepository extends BaseRepository
{
    public function __construct(Employee $employee)
    {
        parent::__construct($employee);
    }

    public function index()
    {
        DB::beginTransaction();

        try {
            $employee = $this->model->all();
            DB::commit();
            return $employee;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function create(array $employeeData)
    {
        DB::beginTransaction();

        try {
            $fileFields = ['nrc_front', 'nrc_back'];
            $employee = $this->createWithFile($employeeData, $fileFields, 'nrcs');
            DB::commit();
            return $employee;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function update($id, array $employeeData, ?array $fileFields = null, string $dir = 'uploads')
    {
        DB::beginTransaction();

        try {
            $employee = $this->updateWithFile($id, $employeeData, $fileFields, $dir);
            DB::commit();
            return $employee;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $employee = $this->model->findOrFail($id);
            
            // Ensure the user associated with the employee is also soft deleted
            if ($employee->user) {
                $employee->user->delete(); // Soft delete the associated user
            }

            // Soft delete the employee
            $employee->delete();

            DB::commit();
            return $employee;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }




}