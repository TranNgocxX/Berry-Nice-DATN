<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetSlotsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'service_id' => 'required|exists:services,id',
            'date' => 'required|date|after_or_equal:today',
        ];
    }

    public function messages(): array
    {
        return [
            'service_id.required' => 'Thiếu dịch vụ.',
            'service_id.exists' => 'Dịch vụ không tồn tại.',
            'date.required' => 'Thiếu ngày.',
            'date.date' => 'Ngày không hợp lệ.',
            'date.after_or_equal' => 'Ngày phải từ hôm nay trở đi.',
        ];
    }
}