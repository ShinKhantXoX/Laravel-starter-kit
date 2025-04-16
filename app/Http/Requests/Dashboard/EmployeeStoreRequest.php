<?php

namespace App\Http\Requests\Dashboard;

use App\Helpers\Enum;
use App\Enums\{
    GeneralStatusEnum,
    EmployeeTypeEnum
};
use Illuminate\Foundation\Http\FormRequest;

class EmployeeStoreRequest extends FormRequest
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
            "user_id" => ["required", "string", "exists:users,id"],
            "employee_no" => ["required", "string", "unique:employees"],
            "name" => ["required", "string"],
            "phone" => ["required", "string"],
            "date" => ["required", "date"],
            "nrc" => ["required", "string", "unique:employees"],
            "nrc_front" => ["required", "image:mimes:jpeg,png,jpg,gif|max:2048"],
            "nrc_back" => ["required", "image:mimes:jpeg,png,jpg,gif|max:2048"],
            "address" => ["required", "string"],
            "father_name" => ["required", "string"],
            "mother_name" => ["required", "string"],
            "join_date" => ["required", "date"],
            "leave_date" => ["required", "date"],
            "remark" => ["required", "string"],
            "employee_type" => ["required", "in:$employeeTypeEnum"],
            "status" => ["required", "in:$generalStatusEnum"]
        ];
    }
}
