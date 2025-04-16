<?php

namespace App\Repositories;

use App\Models\Order;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class OrderRepository extends BaseRepository
{
    public function __construct(Order $order)
    {
        parent::__construct($order);
    }

    public function index()
    {
        DB::beginTransaction();

        try {
            $order = $this->model->all();
            DB::commit();
            return $order;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function create(array $orderData)
    {
        DB::beginTransaction();

        try {
            $order = $this->model->create($orderData);
            DB::commit();
            return $order;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function update($id, array $orderData)
    {
        DB::beginTransaction();

        try {
            $order = $this->model->findOrFail($id);
            $order->update($orderData);
            DB::commit();
            return $order;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $order = $this->model->findOrFail($id);
            $order->delete();

            DB::commit();
            return $order;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

}