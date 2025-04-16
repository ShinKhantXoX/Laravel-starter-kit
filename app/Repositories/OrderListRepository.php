<?php

namespace App\Repositories;

use App\Models\OrderList;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class OrderListRepository extends BaseRepository
{
    public function __construct(OrderList $orderList)
    {
        parent::__construct($orderList);
    }

    public function index()
    {
        DB::beginTransaction();

        try {
            $orderList = $this->model->all();
            DB::commit();
            return $orderList;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function create(array $orderListData)
    {
        DB::beginTransaction();

        try {
            $orderList = $this->model->create($orderListData);
            DB::commit();
            return $orderList;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function update($id, array $orderListData)
    {
        DB::beginTransaction();

        try {
            $orderList = $this->model->findOrFail($id);
            $orderList->update($orderListData);
            DB::commit();
            return $orderList;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $orderList = $this->model->findOrFail($id);
            $orderList->delete();

            DB::commit();
            return $orderList;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

}