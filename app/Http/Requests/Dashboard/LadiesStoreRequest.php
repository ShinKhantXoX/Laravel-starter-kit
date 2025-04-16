<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class LadiesStoreRequest extends FormRequest
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
            'profile' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required|string|max:255',
            'serial_number' => 'required|string|unique:ladies,serial_number',
            'nrc' => 'required|string|max:255',
            'nrc_front' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nrc_back' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'phone_number' => 'required|string|max:255|unique:ladies,phone_number',
            'dob' => 'required|date',
            'address' => 'required|string|max:255',
            'father_name' => 'required|string',
            'mother_name' => 'required|string',
            'join_date' => 'required|date',
            'leave_date' => 'required|date',
            'remark' => 'nullable|string'
        ];
    }
}
