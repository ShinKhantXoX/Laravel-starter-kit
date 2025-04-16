<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserRepository extends BaseRepository
{
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    public function create(array $userData)
    {
        DB::beginTransaction();

        try {
            $userData['password'] = Hash::make($userData['password']);
            $user = $this->model->create($userData);

            // Check if a role is provided and exists
            if (!empty($userData['role'])) {
                $role = Role::where('name', $userData['role'])->where('guard_name', 'dashboard')->first();

                if ($role) {
                    $user->assignRole($role);
                } else {
                    throw new Exception("Role '{$userData['role']}' not found.");
                }
            }

            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }


    public function update($id, array $userData)
    {
        DB::beginTransaction();

        try {
            // Find the user by ID
            $user = $this->model->findOrFail($id);
            
            // Update the user's attributes
            $user->update($userData);

            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }


    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $user = $this->model->findOrFail($id);
            $user->delete();
            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    // This method will return roles and permissions of the currently authenticated user
    public function getUserPermissions()
    {
        // Get the authenticated user
        $user = auth()->user();

        // Check if the user is authenticated
        if (!$user) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

        // Debugging user details
        // dd($user); // Make sure the user is not null and contains the expected information

        // Get roles and permissions
        $roles = $user->getRoleNames(); // Get role names
        // dd($roles); // Check if roles are being fetched properly

        $permissions = $user->getAllPermissions()->pluck('name'); // Get permission names
        // dd($permissions); // Check if permissions are being fetched

        // Return roles and permissions as JSON
        return [
            'roles' => $roles,
            'permissions' => $permissions
        ];
    }


    public function checkEmailExists($email): bool
    {
        return $this->model->whereEmail($email)->count() > 0;
    }

    public function paginate(int $perPage)
    {
        return $this->model->paginate($perPage);
    }
}
