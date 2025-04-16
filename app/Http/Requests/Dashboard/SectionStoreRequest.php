<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class SectionStoreRequest extends FormRequest
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
        return [
            "lady_id" => ["required", "integer", "exists:lady,id"],
            "room_id" => ["required", "integer", "exists:room,id"],
            "check_in" => ["required", "date"],
            "check_out" => ["required", "date"],
            "section" => ["required", "string"]
        ];
    }
}
