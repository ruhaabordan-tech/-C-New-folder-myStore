<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
            'name'=>'sometimes|string|max:255',
           'admin_id'=>'sometimes|exists:admins,id'
        ];
    }

    public function messages(): array
{
    return [
        'name.required'     => 'يجب إدخال اسم القسم (مثلاً: إلكترونيات، منظفات).',
        'name.string'       => 'اسم القسم يجب أن يكون نصاً وليس أرقاماً.',
        'admin_id.required' => 'يجب ربط القسم بمسؤول نظام.',
        'admin_id.exists'   => 'عذراً، المسؤول المختار غير موجود في سجلاتنا.',
    ];
}

}
