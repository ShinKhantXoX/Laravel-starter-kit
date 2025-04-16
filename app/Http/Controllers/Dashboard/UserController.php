<?php
namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Dashboard\UserStoreRequest;
use App\Http\Requests\Dashboard\UserUpdateRequest;
use App\Repositories\UserRepository;
use Exception;

class UserController extends ApiController
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        try {
            // Use repository for fetching users with necessary queries (search, filter, paginate, etc.)
            $user = $this->userRepository->all();
            return $this->successResponse($user, 'User list is successfully retrieved');
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function store(UserStoreRequest $request)
    {
        try {
            $payload = collect($request->validated());
            $user = $this->userRepository->create($payload->toArray());
            return $this->successResponse($user, 'User is successfully created');
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function show($id)
    {
        try {
            // Use repository to find the user by ID
            $user = $this->userRepository->find($id);
            return $this->successResponse($user, 'User is successfully retrieved');
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function update(UserUpdateRequest $request, $id)
    {
        try {
            $payload = collect($request->validated());
            $user = $this->userRepository->update($id, $payload->toArray());
            return $this->successResponse($user, 'User is successfully updated');
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function destroy($id)
    {
        try {
            // Use repository to delete the user
            $user = $this->userRepository->delete($id);
            return $this->successResponse($user, 'User is successfully deleted');
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getUserPermissions()
    {
        try {
            $user = $this->userRepository->getUserPermissions();
            return $this->successResponse($user, "User permission is successfully retrived");
        } catch (Exception $e) {
            throw $e;
        }
    }
}
