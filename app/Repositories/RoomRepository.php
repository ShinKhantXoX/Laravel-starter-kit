<?php

namespace App\Repositories;

use App\Models\Room;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RoomRepository extends BaseRepository
{
    public function __construct(Room $room)
    {
        parent::__construct($room);
    }

    public function index()
    {
        DB::beginTransaction();

        try {
            $room = $this->model->all();
            DB::commit();
            return $room;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function create(array $roomData)
    {
        DB::beginTransaction();

        try {
            $room = $this->model->create($roomData);
            DB::commit();
            return $room;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function update($id, array $roomData)
    {
        DB::beginTransaction();

        try {
            $room = $this->model->findOrFail($id);
            $room->update($roomData);
            DB::commit();
            return $room;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $room = $this->model->findOrFail($id);
            $room->delete();

            DB::commit();
            return $room;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }




}