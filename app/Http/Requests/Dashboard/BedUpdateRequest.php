<?php

namespace App\Http\Requests\Dashboard;

use App\Helpers\Enum;
use App\Enums\IsAvaliableStatusEnum;
use Illuminate\Foundation\Http\FormRequest;

class BedUpdateRequest extends FormRequest
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
            "room_id" => ["nullable", "string", "exists:rooms,id"],
            "label" => ["nullable", "string", "max:255"],
            "bed_number" => ["nullable", "string", "max:255"],
            "remark" => ["nullable", "string", "max:255"],
            "status" => ["nullable", "string", "in:$isAvaliableStatusEnum"]
        ];
    }
}
