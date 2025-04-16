<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Dashboard\UserStoreRequest;
use App\Http\Requests\Dashboard\UserUpdateRequest;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;

class UserController extends ApiController
{
    public function index()
    {
        DB::beginTransaction();

        try {
            $user = User::searchQuery()
                ->sortingQuery()
                ->filterQuery()
                ->filterDateQuery()
                ->paginationQuery();

            DB::commit();

            return $this->successResponse($user ,'User list is successfully retrived');
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function store(UserStoreRequest $request)
    {
        DB::beginTransaction();
        try {
            $payload = collect($request->validated())
                ->put('password', bcrypt($request->password))
                ->toArray();
            $user = User::create($payload);

            DB::commit();

            return $this->successResponse($user ,'User is successfully created');
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function show($id)
    {
        DB::beginTransaction();

        try {
            $user = User::findOrFail($id);

            DB::commit();

            return $this->successResponse($user ,'User is successfully retrived');
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function update(UserUpdateRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            $user = User::findOrFail($id);
            $payload = collect($request->validated())
                ->toArray();
            $user->update($payload);

            DB::commit();

            return $this->successResponse($user ,'User is successfully updated');
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $user = User::findOrFail($id);
            $user->delete();

            DB::commit();

            return $this->successResponse($user ,'User is successfully deleted');
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
