@extends('layouts.admin')

@section('title', 'Sửa danh mục')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Sửa danh mục</h1>
        <p class="text-slate-500">{{ $category->name }}</p>
    </div>

    <div class="bg-white rounded-3xl shadow-sm p-8">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Tên danh mục <span class="text-red-500">*</span></label>
                <input type="text" 
                       name="name" 
                       value="{{ old('name', $category->name) }}"
                       class="w-full px-5 py-4 border border-slate-200 rounded-2xl focus:outline-none focus:border-pink-300 focus:ring-4 focus:ring-pink-100 transition">
                @error('name')<p class="mt-2 text-sm text-red-500">{{ $message }}</p>@enderror
            </div>

            <div class="mb-8">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Mô tả</label>
                <textarea name="description" 
                          rows="5"
                          class="w-full px-5 py-4 border border-slate-200 rounded-2xl focus:outline-none focus:border-pink-300 focus:ring-4 focus:ring-pink-100 transition">{{ old('description', $category->description) }}</textarea>
            </div>

            <div class="flex gap-4">
                <a href="{{ route('admin.categories.index') }}" 
                   class="flex-1 text-center py-4 border border-slate-300 hover:bg-slate-50 rounded-2xl font-medium transition">
                    Quay lại
                </a>
                <button type="submit" 
                        class="flex-1 bg-pink-600 hover:bg-pink-700 text-white py-4 rounded-2xl font-semibold transition shadow-lg shadow-pink-500/30">
                    <i class="fas fa-save mr-2"></i> Cập nhật
                </button>
            </div>
        </form>
    </div>
</div>
@endsection