<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'short_description' => 'nullable',
            'long_description' => 'nullable',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'duration' => 'required|integer|min:1',
            'max_slot' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập tên dịch vụ.',
            'name.max' => 'Tên dịch vụ không được vượt quá 255 ký tự.',
            'category_id.required' => 'Vui lòng chọn danh mục',
            'category_id.exists' => 'Danh mục không hợp lệ.',
            'image.image' => 'Tệp tải lên phải là hình ảnh.',
            'image.mimes' => 'Ảnh phải có định dạng jpg, jpeg hoặc png.',
            'image.max' => 'Ảnh không được vượt quá 2MB.',
            'duration.required' => 'Vui lòng nhập thời lượng dịch vụ.',
            'duration.integer' => 'Thời lượng phải là số nguyên.',
            'duration.min' => 'Thời lượng phải ít nhất là 1 phút.',
            'max_slot.required' => 'Vui lòng nhập số lượng slot.',
            'max_slot.integer' => 'Slot phải là số nguyên.',
            'max_slot.min' => 'Slot phải ít nhất là 1.',
            'price.required' => 'Vui lòng nhập giá dịch vụ.',
            'price.numeric' => 'Giá phải là số.',
            'price.min' => 'Giá không được nhỏ hơn 0.'
        ];
    }
}
