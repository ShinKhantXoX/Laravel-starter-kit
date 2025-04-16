<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Ladies;
use App\Http\Controllers\ApiController;
use App\Repositories\LadieRepository;
use App\Http\Requests\Dashboard\LadiesStoreRequest;
use App\Http\Requests\Dashboard\LadiesUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class LadiesController extends ApiController
{

    protected $ladieRepository;

    public function __construct(LadieRepository $ladieRepository)
    {
        $this->ladieRepository = $ladieRepository;
    }

    public function index()
    {
        try{

            $ladie = $this->ladieRepository->index();
            return $this->successResponse($ladie,"Ladies list is retrived successfully");

        } catch(Exception $e) {
            throw $e;
        }
    }

    public function store(LadiesStoreRequest $request)
    {
        try {
            $payload = collect($request->validated());
            $ladie = $this->ladieRepository->create($payload->toArray());
            return $this->successResponse($ladie, 'Ladies is successfully created');
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function show($id)
    {
        try {
            $ladie = $this->ladieRepository->find($id);
            return $this->successResponse($ladie ,'Ladies is successfully retrived');
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function update(LadiesUpdateRequest $request, $id)
    {
        try {
            $payload = collect($request->validated());
            $ladie = $this->ladieRepository->update($id, $payload->toArray(), ['nrc_front', 'nrc_back'], 'nrcs');
            return $this->successResponse($ladies, 'Ladies is successfully updated');
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function destroy($id)
    {
        try {
            $ladie = $this->ladieRepository->delete($id);
            return $this->successResponse($ladies, 'Ladies is successfully deleted');
        } catch (Exception $e) {
            throw $e;
        }
    }
}
