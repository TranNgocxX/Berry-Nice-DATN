@extends('layouts.admin')

@section('title', 'Thêm loại dịch vụ mới')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Thêm loại dịch vụ mới</h1>
        <p class="text-slate-500">Tạo danh mục dịch vụ cho hệ thống Spa</p>
    </div>

    <div class="bg-white rounded-3xl shadow-sm p-8">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf

            <div class="mb-6">
                <label class="block text-sm font-semibold text-slate-700 mb-2">
                    Tên loại dịch vụ <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="name" 
                       value="{{ old('name') }}"
                       class="w-full px-5 py-4 border rounded-2xl focus:outline-none transition 
                       {{ $errors->has('name') ? 'border-red-500 focus:ring-4 focus:ring-red-100' : 'border-slate-200 focus:border-pink-300 focus:ring-4 focus:ring-pink-100' }}"
                       placeholder="Ví dụ: Massage thư giãn">
                @error('name') <p class="mt-1 text-red-500 text-sm"> {{ $message }}</p> @enderror
            </div>

            <div class="mb-8">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Mô tả</label>
                <textarea name="description" 
                          rows="5"
                          class="w-full px-5 py-4 border border-slate-200 rounded-2xl focus:outline-none focus:border-pink-300 focus:ring-4 focus:ring-pink-100 transition"
                          placeholder="Mô tả chi tiết về loại dịch vụ...">{{ old('description') }}</textarea>
            </div>

            <div class="flex gap-4">
                <a href="{{ route('admin.categories.index') }}" 
                   class="flex-1 text-center py-4 border border-slate-300 hover:border-slate-400 rounded-2xl font-medium text-slate-600 transition">
                    Quay lại
                </a>
                <button type="submit" 
                        class="flex-1 bg-pink-600 hover:bg-pink-700 text-white py-4 rounded-2xl font-semibold transition shadow-lg shadow-pink-500/30">
                    <i class="fas fa-save mr-2"></i>
                    Lưu loại dịch vụ
                </button>
            </div>
        </form>
    </div>
</div>
@endsection