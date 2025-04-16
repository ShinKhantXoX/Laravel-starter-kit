<?php

namespace App\Repositories;

use App\Models\Ladies;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class LadieRepository extends BaseRepository
{
    public function __construct(Ladies $ladies)
    {
        parent::__construct($ladies);
    }

    public function index()
    {
        DB::beginTransaction();

        try {
            $ladies = $this->model->all();
            DB::commit();
            return $ladies;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function create(array $ladiesData)
    {
        DB::beginTransaction();

        try {
            $fileFields = ['nrc_front', 'nrc_back', 'profile'];
            $ladies = $this->createWithFile($ladiesData, $fileFields, 'nrcs');
            DB::commit();
            return $ladies;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function update($id, array $ladiesData, ?array $fileFields = null, string $dir = 'uploads')
    {
        DB::beginTransaction();

        try {
            $ladies = $this->updateWithFile($id, $ladiesData, $fileFields, $dir);
            DB::commit();
            return $ladies;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $ladies = $this->model->findOrFail($id);
            $ladies->delete();

            DB::commit();
            return $ladies;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }




}