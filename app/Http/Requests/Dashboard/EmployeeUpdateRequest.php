<?php

namespace App\Http\Requests\Dashboard;

use App\Helpers\Enum;
use App\Enums\{
    GeneralStatusEnum,
    EmployeeTypeEnum
};
use Illuminate\Foundation\Http\FormRequest;

class EmployeeUpdateRequest extends FormRequest
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
        $employeeTypeEnum = implode(',', (new Enum(EmployeeTypeEnum::class))->values());
        $generalStatusEnum = implode(',', (new Enum(GeneralStatusEnum::class))->values());

        return [
            "user_id" => ["nullable", "string", "exists:users,id"],
            "employee_no" => ["nullable", "string", "unique:employees"],
            "name" => ["nullable", "string"],
            "phone" => ["nullable", "string"],
            "date" => ["nullable", "date"],
            "nrc" => ["nullable", "string", "unique:employees"],
            "nrc_front" => ["nullable", "image:mimes:jpeg,png,jpg,gif|max:2048"],
            "nrc_back" => ["nullable", "image:mimes:jpeg,png,jpg,gif|max:2048"],
            "address" => ["nullable", "string"],
            "father_name" => ["nullable", "string"],
            "mother_name" => ["nullable", "string"],
            "join_date" => ["nullable", "date"],
            "leave_date" => ["nullable", "date"],
            "remark" => ["nullable", "string"],
            "employee_type" => ["nullable", "in:$employeeTypeEnum"],
            "status" => ["nullable", "in:$generalStatusEnum"]
        ];
    }
}
