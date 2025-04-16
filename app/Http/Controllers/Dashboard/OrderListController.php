<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\ApiController;
use App\Repositories\OrderListRepository;
use App\Http\Requests\Dashboard\OrderListStoreRequest;
use App\Http\Requests\Dashboard\OrderListUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class OrderListController extends ApiController
{

    protected $orderListRepository;

    public function __construct(OrderListRepository $orderListRepository)
    {
        $this->orderListRepository = $orderListRepository;
    }


    public function index () 
    {
        try {
            $OrderList = $this->orderListRepository->index();
            return $this->successResponse($OrderList, 'Order list is successfully retrived');
        } catch (Exception $e) {
            throw $e;
        }

    }

    public function store(OrderListStoreRequest $OrderListStoreRequest)
    {
        try {
            $payload = collect($OrderListStoreRequest->validated());
            $OrderList = $this->orderListRepository->create($payload->toArray());
            return $this->successResponse($OrderList, 'Order is created successfully');
        } catch(Exception $e) {
            throw $e;
        }
    }

    public function show($id)
    {
        try {
            $OrderList = $this->orderListRepository->find($id);
            return $this->successResponse($OrderList ,'Order is successfully retrived');
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function update(OrderListUpdateRequest $OrderListUpdateRequest, $id)
    {
        try {
            $payload = collect($OrderListUpdateRequest->validated());
            $OrderList = $this->orderListRepository->update($id, $payload->toArray());
            return $this->successResponse($OrderList, 'Order is updated successfully');
        } catch(Exception $e) {
            throw $e;
        }
    }

    public function destroy($id)
    {
        try {
            $OrderList = $this->orderListRepository->delete($id);
            return $this->successResponse($OrderList, 'Order is deleted successfully');
        } catch(Exception $e) {
            throw $e;
        }
    }

}
