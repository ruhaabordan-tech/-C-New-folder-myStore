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
        'amount' => 'sometimes|numeric|min:0',
        'reason' => 'nullable|string',
        'entry_date' => 'sometimes|date'
        ];
    }
}
