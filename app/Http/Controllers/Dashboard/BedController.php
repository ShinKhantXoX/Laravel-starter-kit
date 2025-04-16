<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\ApiController;
use App\Repositories\BedRepository;
use App\Http\Requests\Dashboard\BedStoreRequest;
use App\Http\Requests\Dashboard\BedUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class BedController extends ApiController
{

    protected $bedRepository;

    public function __construct(BedRepository $bedRepository)
    {
        $this->bedRepository = $bedRepository;
    }


    public function index () 
    {
        try {
            $Bed = $this->bedRepository->index();
            return $this->successResponse($Bed, 'Bed list is successfully retrived');
        } catch (Exception $e) {
            throw $e;
        }

    }

    public function store(BedStoreRequest $BedStoreRequest)
    {
        try {
            $payload = collect($BedStoreRequest->validated());
            $Bed = $this->bedRepository->create($payload->toArray());
            return $this->successResponse($Bed, 'Bed is created successfully');
        } catch(Exception $e) {
            throw $e;
        }
    }

    public function show($id)
    {
        try {
            $Bed = $this->bedRepository->find($id);
            return $this->successResponse($Bed ,'Bed is successfully retrived');
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function update(BedUpdateRequest $BedUpdateRequest, $id)
    {
        try {
            $payload = collect($BedUpdateRequest->validated());
            $Bed = $this->bedRepository->update($id, $payload->toArray());
            return $this->successResponse($Bed, 'Bed is updated successfully');
        } catch(Exception $e) {
            throw $e;
        }
    }

    public function destroy($id)
    {
        try {
            $Bed = $this->bedRepository->delete($id);
            return $this->successResponse($Bed, 'Bed is deleted successfully');
        } catch(Exception $e) {
            throw $e;
        }
    }

}
