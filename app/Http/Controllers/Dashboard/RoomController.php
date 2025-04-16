<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\ApiController;
use App\Repositories\RoomRepository;
use App\Http\Requests\Dashboard\RoomStoreRequest;
use App\Http\Requests\Dashboard\RoomUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class RoomController extends ApiController
{

    protected $roomRepository;

    public function __construct(RoomRepository $roomRepository)
    {
        $this->roomRepository = $roomRepository;
    }


    public function index () 
    {
        try {
            $Room = $this->roomRepository->index();
            return $this->successResponse($Room, 'Room list is successfully retrived');
        } catch (Exception $e) {
            throw $e;
        }

    }

    public function store(RoomStoreRequest $RoomStoreRequest)
    {
        try {
            $payload = collect($RoomStoreRequest->validated());
            $Room = $this->roomRepository->create($payload->toArray());
            return $this->successResponse($Room, 'Room is created successfully');
        } catch(Exception $e) {
            throw $e;
        }
    }

    public function show($id)
    {
        try {
            $Room = $this->roomRepository->find($id);
            return $this->successResponse($Room ,'Room is successfully retrived');
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function update(RoomUpdateRequest $RoomUpdateRequest, $id)
    {
        try {
            $payload = collect($RoomUpdateRequest->validated());
            $Room = $this->roomRepository->update($id, $payload->toArray());
            return $this->successResponse($Room, 'Room is updated successfully');
        } catch(Exception $e) {
            throw $e;
        }
    }

    public function destroy($id)
    {
        try {
            $Room = $this->roomRepository->delete($id);
            return $this->successResponse($Room, 'Room is deleted successfully');
        } catch(Exception $e) {
            throw $e;
        }
    }

}
