<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\ApiController;
use App\Repositories\MenuCategoryRepository;
use App\Http\Requests\Dashboard\MenuCategoryStoreRequest;
use App\Http\Requests\Dashboard\MenuCategoryUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class MenuCategoryController extends ApiController
{

    protected $menuCategoryRepository;

    public function __construct(MenuCategoryRepository $menuCategoryRepository)
    {
        $this->menuCategoryRepository = $menuCategoryRepository;
    }


    public function index () 
    {
        try {
            $MenuCategory = $this->menuCategoryRepository->index();
            return $this->successResponse($MenuCategory, 'MenuCategory list is successfully retrived');
        } catch (Exception $e) {
            throw $e;
        }

    }

    public function store(MenuCategoryStoreRequest $MenuCategoryStoreRequest)
    {
        try {
            $payload = collect($MenuCategoryStoreRequest->validated());
            $MenuCategory = $this->menuCategoryRepository->create($payload->toArray());
            return $this->successResponse($MenuCategory, 'MenuCategory is created successfully');
        } catch(Exception $e) {
            throw $e;
        }
    }

    public function show($id)
    {
        try {
            $MenuCategory = $this->menuCategoryRepository->find($id);
            return $this->successResponse($MenuCategory ,'MenuCategory is successfully retrived');
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function update(MenuCategoryUpdateRequest $MenuCategoryUpdateRequest, $id)
    {
        try {
            $payload = collect($MenuCategoryUpdateRequest->validated());
            $MenuCategory = $this->menuCategoryRepository->update($id, $payload->toArray(), ['nrc_front', 'nrc_back'], 'nrcs');
            return $this->successResponse($MenuCategory, 'MenuCategory is updated successfully');
        } catch(Exception $e) {
            throw $e;
        }
    }

    public function destroy($id)
    {
        try {
            $MenuCategory = $this->menuCategoryRepository->delete($id);
            return $this->successResponse($MenuCategory, 'MenuCategory is deleted successfully');
        } catch(Exception $e) {
            throw $e;
        }
    }

}
