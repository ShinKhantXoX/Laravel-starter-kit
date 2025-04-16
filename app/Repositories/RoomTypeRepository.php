<?php

namespace App\Repositories;

use App\Models\RoomType;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RoomTypeRepository extends BaseRepository
{
    public function __construct(RoomType $roomType)
    {
        parent::__construct($roomType);
    }

    public function index()
    {
        DB::beginTransaction();

        try {
            $roomType = $this->model->all();
            DB::commit();
            return $roomType;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function create(array $roomTypeData)
    {
        DB::beginTransaction();

        try {
            $roomType = $this->model->create($roomTypeData);
            DB::commit();
            return $roomType;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function update($id, array $roomTypeData)
    {
        DB::beginTransaction();

        try {
            $roomType = $this->model->findOrFail($id);
            $roomType->update($roomTypeData);
            DB::commit();
            return $roomType;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $roomType = $this->model->findOrFail($id);
            $roomType->delete();

            DB::commit();
            return $roomType;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }




}