<?php

namespace App\Repositories;

use App\Models\Bed;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class BedRepository extends BaseRepository
{
    public function __construct(Bed $bed)
    {
        parent::__construct($bed);
    }

    public function index()
    {
        DB::beginTransaction();

        try {
            $bed = $this->model->all();
            DB::commit();
            return $bed;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function create(array $bedData)
    {
        DB::beginTransaction();

        try {
            $bed = $this->model->create($bedData);
            DB::commit();
            return $bed;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function update($id, array $bedData)
    {
        DB::beginTransaction();

        try {
            $bed = $this->model->findOrFail($id);
            $bed->update($bedData);
            DB::commit();
            return $bed;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $bed = $this->model->findOrFail($id);
            $bed->delete();

            DB::commit();
            return $bed;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }




}