<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest
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
              'name'=> 'sometimes|string|max:40',
        'email'=> 'sometimes',
        'phone'=> 'sometimes|integer',
        'address'=>'sometimes'
        ];
    }

    public function messages(): array
  {
    return [
        'name.required'    => 'يرجى إدخال اسم المسؤول، هذا الحقل مطلوب.',
        'email.required'   => 'البريد الإلكتروني مطلوب للتواصل مع المسؤول.',
        'phone.required'   => 'رقم الهاتف مطلوب لتسجيل بيانات المسؤول.',
        'phone.integer'    => 'يجب أن يكون رقم الهاتف عبارة عن أرقام فقط.',
        'address.required' => 'يرجى إدخال عنوان المسؤول.',
    ];
  }

}
