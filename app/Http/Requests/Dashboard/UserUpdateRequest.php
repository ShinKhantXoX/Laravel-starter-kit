<?php

namespace App\Http\Requests\Dashboard;

use App\Enums\{
    RoleTypeEnum,
    UserStatusEnum
};
use App\Helpers\Enum;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $roles = implode(',', (new Enum(RoleTypeEnum::class))->values());
        $status = implode(',', (new Enum(UserStatusEnum::class))->values());
        return [
            'username' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['nullable', 'string', 'min:8', 'unique:users'],
            'password' => ['nullable', 'string', 'min:8'],
            "role" => "nullable|in:$roles",
            "status" => "nullable|in:$status"
        ];
    }
}
