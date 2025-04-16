<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\ApiController;
use App\Repositories\MenuRepository;
use App\Http\Requests\Dashboard\MenuStoreRequest;
use App\Http\Requests\Dashboard\MenuUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class MenuController extends ApiController
{

    protected $menuRepository;

    public function __construct(MenuRepository $menuRepository)
    {
        $this->menuRepository = $menuRepository;
    }


    public function index () 
    {
        try {
            $Menu = $this->menuRepository->index();
            return $this->successResponse($Menu, 'Menu list is successfully retrived');
        } catch (Exception $e) {
            throw $e;
        }

    }

    public function store(MenuStoreRequest $MenuStoreRequest)
    {
        try {
            $payload = collect($MenuStoreRequest->validated());
            $Menu = $this->menuRepository->create($payload->toArray());
            return $this->successResponse($Menu, 'Menu is created successfully');
        } catch(Exception $e) {
            throw $e;
        }
    }

    public function show($id)
    {
        try {
            $Menu = $this->menuRepository->find($id);
            return $this->successResponse($Menu ,'Menu is successfully retrived');
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function update(MenuUpdateRequest $MenuUpdateRequest, $id)
    {
        try {
            $payload = collect($MenuUpdateRequest->validated());
            $Menu = $this->menuRepository->update($id, $payload->toArray(), ['photo'], 'photos');
            return $this->successResponse($Menu, 'Menu is updated successfully');
        } catch(Exception $e) {
            throw $e;
        }
    }

    public function destroy($id)
    {
        try {
            $Menu = $this->menuRepository->delete($id);
            return $this->successResponse($Menu, 'Menu is deleted successfully');
        } catch(Exception $e) {
            throw $e;
        }
    }

}
