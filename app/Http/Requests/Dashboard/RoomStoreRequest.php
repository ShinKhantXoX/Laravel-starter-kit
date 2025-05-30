<?php

namespace App\Http\Requests\Dashboard;

use App\Helpers\Enum;
use App\Enums\IsAvaliableStatusEnum;
use Illuminate\Foundation\Http\FormRequest;

class RoomStoreRequest extends FormRequest
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
        $isAvaliableStatusEnum = implode(',', (new Enum(IsAvaliableStatusEnum::class))->values());

        return [
            "room_type_id" => ["required", "string", "exists:room_types,id"],
            "name" => ["required", "string", "max:255"],
            "room_number" => ["required", "string", "max:255"],
            "status" => ["required", "string", "in:$isAvaliableStatusEnum"]
        ];
    }
}
