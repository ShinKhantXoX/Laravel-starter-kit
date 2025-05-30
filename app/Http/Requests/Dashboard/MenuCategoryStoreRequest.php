<?php

namespace App\Http\Requests\Dashboard;

use App\Helpers\Enum;
use App\Enums\GeneralStatusEnum;
use Illuminate\Foundation\Http\FormRequest;

class MenuCategoryStoreRequest extends FormRequest
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
        $GeneralStatusEnum = implode(',', (new Enum(GeneralStatusEnum::class))->values());

        return [
            "label" => ["required", "string", "max:255"],
            "description" => ["required", "string"],
            "status" => ["required", "string", "in:$GeneralStatusEnum"]
        ];
    }
}
