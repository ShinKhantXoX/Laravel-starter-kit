<?php

namespace App\Repositories;

use App\Models\MenuCategory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class MenuCategoryRepository extends BaseRepository
{
    public function __construct(MenuCategory $menuCategory)
    {
        parent::__construct($menuCategory);
    }

    public function index()
    {
        DB::beginTransaction();

        try {
            $menuCategory = $this->model->all();
            DB::commit();
            return $menuCategory;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function create(array $menuCategoryData)
    {
        DB::beginTransaction();

        try {
            $menuCategory = $this->model->create($menuCategoryData);
            DB::commit();
            return $menuCategory;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function update($id, array $menuCategoryData)
    {
        DB::beginTransaction();

        try {
            $menuCategory = $this->model->findOrFail($id);
            $menuCategory->update($menuCategoryData);
            DB::commit();
            return $menuCategory;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $menuCategory = $this->model->findOrFail($id);
            $menuCategory->delete();

            DB::commit();
            return $menuCategory;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }




}