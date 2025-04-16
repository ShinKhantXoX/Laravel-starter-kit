<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\ApiController;
use App\Repositories\RoomTypeRepository;
use App\Http\Requests\Dashboard\RoomTypeStoreRequest;
use App\Http\Requests\Dashboard\RoomTypeUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class RoomTypeController extends ApiController
{

    protected $roomTypeRepository;

    public function __construct(RoomTypeRepository $roomTypeRepository)
    {
        $this->roomTypeRepository = $roomTypeRepository;
    }


    public function index () 
    {
        try {
            $RoomType = $this->roomTypeRepository->index();
            return $this->successResponse($RoomType, 'RoomType list is successfully retrived');
        } catch (Exception $e) {
            throw $e;
        }

    }

    public function store(RoomTypeStoreRequest $RoomTypeStoreRequest)
    {
        try {
            $payload = collect($RoomTypeStoreRequest->validated());
            $RoomType = $this->roomTypeRepository->create($payload->toArray());
            return $this->successResponse($RoomType, 'RoomType is created successfully');
        } catch(Exception $e) {
            throw $e;
        }
    }

    public function show($id)
    {
        try {
            $RoomType = $this->roomTypeRepository->find($id);
            return $this->successResponse($RoomType ,'RoomType is successfully retrived');
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function update(RoomTypeUpdateRequest $RoomTypeUpdateRequest, $id)
    {
        try {
            $payload = collect($RoomTypeUpdateRequest->validated());
            $RoomType = $this->roomTypeRepository->update($id, $payload->toArray());
            return $this->successResponse($RoomType, 'RoomType is updated successfully');
        } catch(Exception $e) {
            throw $e;
        }
    }

    public function destroy($id)
    {
        try {
            $RoomType = $this->roomTypeRepository->delete($id);
            return $this->successResponse($RoomType, 'RoomType is deleted successfully');
        } catch(Exception $e) {
            throw $e;
        }
    }

}
