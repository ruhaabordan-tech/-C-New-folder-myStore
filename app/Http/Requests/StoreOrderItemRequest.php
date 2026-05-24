<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrderItemRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
              'order_id' => 'required|exists:orders,id',
        'product_id' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1',
        'price' => 'required|numeric'
        ];
    }

    public function messages(): array
{
    return [
        'order_id.required'   => 'يجب ربط الصنف بطلب بيع موجود.',
        'order_id.exists'     => 'رقم الطلب المختار غير صحيح أو غير موجود.',
        'product_id.required' => 'يرجى اختيار المنتج المراد إضافته للفاتورة.',
        'product_id.exists'   => 'المنتج المختار غير موجود في المخزن.',
        'quantity.required'   => 'يرجى تحديد الكمية المطلوبة.',
        'quantity.integer'    => 'الكمية يجب أن تكون رقماً صحيحاً.',
        'quantity.min'        => 'يجب أن تكون الكمية 1 على الأقل.',
        'price.required'      => 'يجب تسجيل سعر البيع لهذا الصنف.',
        'price.numeric'       => 'السعر يجب أن يكون قيمة رقمية.',
    ];
}

}
