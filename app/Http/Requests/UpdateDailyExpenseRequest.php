<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDailyExpenseRequest extends FormRequest
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
                  'admin_id' => 'sometimes|exists:admins,id',
        'amount' => 'sometimes|numeric|min:1',
        'reason' => 'nullable|string',
        'entry_date' => 'sometimes|date'
        ];
    }

    public function messages(): array
{
    return [
        'admin_id.required'   => 'يجب ربط المصروف بمسؤول نظام.',
        'admin_id.exists'     => 'المسؤول المختار غير موجود في سجلاتنا.',
        'amount.required'     => 'يرجى إدخال مبلغ المصروف.',
        'amount.numeric'      => 'يجب أن يكون المبلغ قيمة رقمية.',
        'amount.min'          => 'لا يمكن تسجيل مصروف بقيمة صفر، يرجى إدخال مبلغ صحيح.',
        'entry_date.required' => 'يرجى تحديد تاريخ تسجيل هذا المصروف.',
        'entry_date.date'     => 'تنسيق التاريخ غير صحيح، يرجى اختيار تاريخ صالح.',
    ];
}

}
