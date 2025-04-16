<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\ApiController;
use App\Repositories\EmployeeRepository;
use App\Http\Requests\Dashboard\EmployeeStoreRequest;
use App\Http\Requests\Dashboard\EmployeeUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class EmployeeController extends ApiController
{

    protected $employeeRepository;

    public function __construct(EmployeeRepository $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }


    public function index () 
    {
        try {
            $employee = $this->employeeRepository->index();
            return $this->successResponse($employee, 'Employee list is successfully retrived');
        } catch (Exception $e) {
            throw $e;
        }

    }

    public function store(EmployeeStoreRequest $employeeStoreRequest)
    {
        try {
            $payload = collect($employeeStoreRequest->validated());
            $employee = $this->employeeRepository->create($payload->toArray());
            return $this->successResponse($employee, 'Employee is created successfully');
        } catch(Exception $e) {
            throw $e;
        }
    }

    public function show($id)
    {
        try {
            $employee = $this->employeeRepository->find($id);
            return $this->successResponse($employee ,'Employee is successfully retrived');
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function update(EmployeeUpdateRequest $employeeUpdateRequest, $id)
    {
        try {
            $payload = collect($employeeUpdateRequest->validated());
            $employee = $this->employeeRepository->update($id, $payload->toArray(), ['nrc_front', 'nrc_back'], 'nrcs');
            return $this->successResponse($employee, 'Employee is updated successfully');
        } catch(Exception $e) {
            throw $e;
        }
    }

    public function destroy($id)
    {
        try {
            $employee = $this->employeeRepository->delete($id);
            return $this->successResponse($employee, 'Employee is deleted successfully');
        } catch(Exception $e) {
            throw $e;
        }
    }

}
