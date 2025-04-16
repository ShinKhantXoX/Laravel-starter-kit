<?php

namespace App\Http\Requests\Dashboard;

use App\Helpers\Enum;
use App\Enums\IsAvaliableStatusEnum;
use Illuminate\Foundation\Http\FormRequest;

class MenuStoreRequest extends FormRequest
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
            "menu_category_id" => ["required", "string", "exists:menu_categories,id"],
            "name" => ["required", "string", "max:255"],
            "price" => ["required", "numeric"],
            "photo" => ["nullable", "image", "mimes:jpeg,png,jpg,gif,svg", "max:2048"],
            "status" => ["required", "string", "in:$isAvaliableStatusEnum"]
        ];
    }
}
