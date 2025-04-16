<?php

namespace App\Http\Requests\Dashboard;

use App\Helpers\Enum;
use App\Enums\{
    PaymentTypeEnum,
    GeneralStatusEnum
};
use Illuminate\Foundation\Http\FormRequest;

class OrderStoreRequest extends FormRequest
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
        $paymentTypeEnum = implode(',', (new Enum(PaymentTypeEnum::class))->values());
        $generalStatusEnum = implode(',', (new Enum(GeneralStatusEnum::class))->values());

        return [
            "room_id" => ["required", "string", "exists:rooms,id"],
            "bed_id" => ["required", "string", "exists:beds,id"],
            "total_amount" => ["required", "numeric"],
            "pay_amount" => ["required", "numeric"],
            "refund_amount" => ["required", "numeric"],
            "remark" => ["nullable", "string"],
            "payment_type" => ["required", "string", "in:$paymentTypeEnum"],
            "status" => ["required", "string", "in:$generalStatusEnum"]
        ];
    }
}
