<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
        'name'               => 'required|string',
        'price'              => 'required|numeric',
        'quantity'           => 'required|integer',
        'description'        => 'required|string', 
        'min_quantity_alert' => 'nullable|integer', 
        'image'              => 'nullable|string',  
        'category_name' => 'required|string',
    ];
}

public function messages(): array
{
    return [
        'name.required'          => 'يرجى إدخال اسم المنتج، هذا الحقل إلزامي.',
        'price.required'         => 'يجب تحديد سعر المنتج.',
        'price.numeric'          => 'سعر المنتج يجب أن يكون رقماً.',
        'quantity.required'      => 'يرجى إدخال الكمية المتوفرة في المخزن.',
        'quantity.integer'       => 'الكمية يجب أن تكون عدداً صحيحاً.',
        'description.required'   => 'يرجى كتابة وصف بسيط للمنتج.',
        'category_name.required' => 'يجب إدخال اسم القسم الذي ينتمي إليه المنتج.',
    ];
}


}
