<?php

namespace App\Repositories;

use App\Models\Menu;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class MenuRepository extends BaseRepository
{
    public function __construct(Menu $menu)
    {
        parent::__construct($menu);
    }

    public function index()
    {
        DB::beginTransaction();

        try {
            $menu = $this->model->all();
            DB::commit();
            return $menu;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function create(array $menuData)
    {
        DB::beginTransaction();

        try {
            $fileFields = ['photo'];
            $menu = $this->createWithFile($menuData, $fileFields, "photos");
            DB::commit();
            return $menu;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function update($id, array $menuData, ?array $fileFields = null, string $dir = 'uploads')
    {
        DB::beginTransaction();

        try {
            $menu = $this->updateWithFile($id, $menuData, $fileFields, $dir);
            DB::commit();
            return $menu;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $menu = $this->model->findOrFail($id);
            $menu->delete();

            DB::commit();
            return $menu;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }




}