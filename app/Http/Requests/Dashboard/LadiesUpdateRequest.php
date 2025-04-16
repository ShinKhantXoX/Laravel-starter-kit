<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class LadiesUpdateRequest extends FormRequest
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
            'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'nullable|string|max:255',
            'nrc' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255|unique:ladies,phone',
            'dob' => 'nullable|date',
            'address' => 'nullable|string|max:255',
            'join_date' => 'nullable|date',
            'leave_date' => 'nullable|date',
        ];
    }
}
