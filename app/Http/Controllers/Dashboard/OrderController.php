<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\ApiController;
use App\Repositories\OrderRepository;
use App\Http\Requests\Dashboard\OrderStoreRequest;
use App\Http\Requests\Dashboard\OrderUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class OrderController extends ApiController
{

    protected $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }


    public function index () 
    {
        try {
            $Order = $this->orderRepository->index();
            return $this->successResponse($Order, 'Order list is successfully retrived');
        } catch (Exception $e) {
            throw $e;
        }

    }

    public function store(OrderStoreRequest $OrderStoreRequest)
    {
        try {
            $payload = collect($OrderStoreRequest->validated());
            $Order = $this->orderRepository->create($payload->toArray());
            return $this->successResponse($Order, 'Order is created successfully');
        } catch(Exception $e) {
            throw $e;
        }
    }

    public function show($id)
    {
        try {
            $Order = $this->orderRepository->find($id);
            return $this->successResponse($Order ,'Order is successfully retrived');
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function update(OrderUpdateRequest $OrderUpdateRequest, $id)
    {
        try {
            $payload = collect($OrderUpdateRequest->validated());
            $Order = $this->orderRepository->update($id, $payload->toArray());
            return $this->successResponse($Order, 'Order is updated successfully');
        } catch(Exception $e) {
            throw $e;
        }
    }

    public function destroy($id)
    {
        try {
            $Order = $this->orderRepository->delete($id);
            return $this->successResponse($Order, 'Order is deleted successfully');
        } catch(Exception $e) {
            throw $e;
        }
    }

}
