<?php

namespace App\Http\Requests\Dashboard;

use App\Helpers\Enum;
use App\Enums\OrderItemStatusEnum;
use Illuminate\Foundation\Http\FormRequest;

class OrderListUpdateRequest extends FormRequest
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
        $OrderItemStatusEnum = implode(',', (new Enum(OrderItemStatusEnum::class))->values());

        return [
            'order_id' => ['nullable', 'string', 'exists:orders,id'],
            'menu_id' => ['nullable', 'string', 'exists:menus,id'],
            'quantity' => ['nullable', 'numeric'],
            'name' => ['nullable', 'string', 'max:255', 'unique:order_lists'],
            'price' => ['nullable', 'numeric'],
            'amount' => ['nullable', 'numeric'],
            'status' => ['nullable', 'string', "in:$OrderItemStatusEnum"]
        ];
    }
}
