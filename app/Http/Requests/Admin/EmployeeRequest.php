<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $employeeId = $this->route('employee') ? $this->route('employee')->id : null;

        return [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:10|regex:/^[0-9]+$/',
            'email' => 'nullable|email|unique:employees,email,' . $employeeId,
            'service_ids' => 'required|array'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập tên nhân viên.',
            'name.max' => 'Tên nhân viên không được vượt quá 255 ký tự.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.regex' => 'Số điện thoại chỉ được chứa các ký tự số.',
            'phone.max' => 'Số điện thoại không được vượt quá 10 ký tự.',
            'email.email' => 'Vui lòng nhập địa chỉ email hợp lệ.',
            'email.unique' => 'Địa chỉ email đã tồn tại.',
            'service_ids.required' => 'Vui lòng chọn ít nhất một dịch vụ cho nhân viên.'
        ];
    }
}