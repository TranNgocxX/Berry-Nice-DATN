<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'service_id' => 'required|exists:services,id',
            'start_time' => 'required|date|after_or_equal:now',
            'customer_name' => 'required|string|max:255',
            'phone' => 'required|regex:/^0[0-9]{9}$/',
            'email' => 'required|email|max:255',
            'address' => 'nullable|string|max:255',
            'payment_method' => 'required|in:cash,qr',
            'health_status' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
        ];
    }

    public function messages()
    {
        return [
            'customer_name.required' => 'Vui lòng nhập họ và tên.',
            'start_time.after'        => 'Khung giờ chọn đã qua, vui lòng chọn giờ khác.',
            'email.email' => 'Vui lòng nhập địa chỉ email hợp lệ.',
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.regex' => 'Số điện thoại không đúng định dạng.',
            'start_time.required' => 'Vui lòng chọn khung giờ.',
            'payment_method.required' => 'Vui lòng chọn hình thức thanh toán.',
        ];
    }
}
