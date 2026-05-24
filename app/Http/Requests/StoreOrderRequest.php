<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
        'total_price' => 'required|numeric',
        'status'      => 'required|in:pending,processing,completed,cancelled',
        'admin_id'    => 'required|exists:admins,id',
        'items'              => 'required|array|min:1',
        'items.*.product_id' => 'required|exists:products,id',
        'items.*.quantity'   => 'required|integer|min:1',
    ];
}
public function messages(): array
{
    return [
        'total_price.required' => 'يجب إدخال إجمالي سعر الطلب.',
        'total_price.numeric'  => 'سعر الطلب يجب أن يكون رقماً.',
        'status.required'      => 'يرجى تحديد حالة الطلب.',
        'status.in'            => 'الحالة المختارة غير صالحة، يرجى اختيار حالة صحيحة.',
        'admin_id.required'    => 'يجب ربط العملية بمسؤول نظام.',
        'admin_id.exists'      => 'المسؤول المختار غير موجود في النظام.',
        'items.required'       => 'لا يمكن تسجيل طلب فارغ، يرجى إضافة منتج واحد على الأقل.',
        'items.array'          => 'تنسيق المنتجات المبيعة غير صحيح.',
        'items.min'            => 'يجب إضافة منتج واحد على الأقل لإتمام العملية.',
        'items.*.product_id.required' => 'يجب تحديد المنتج لكل صنف في الطلب.',
        'items.*.product_id.exists'   => 'أحد المنتجات المختارة غير موجود في المخزن.',
        'items.*.quantity.required'   => 'يرجى تحديد الكمية المطلوبة لكل منتج.',
        'items.*.quantity.min'        => 'يجب أن تكون الكمية لكل منتج 1 على الأقل.',
    ];
}


    }

