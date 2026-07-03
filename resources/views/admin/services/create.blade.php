@extends('layouts.admin')

@section('title', 'Thêm dịch vụ mới')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Thêm mới</h1>
        <p class="text-slate-500">Tạo dịch vụ Spa cho khách hàng</p>
    </div>

    <div class="bg-white rounded-3xl shadow-sm p-8">
        <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Tên dịch vụ <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" 
                           class="w-full px-5 py-4 border border-slate-200 rounded-2xl focus:outline-none focus:border-pink-300 focus:ring-pink-100"
                           placeholder="Ví dụ: Massage Thư Giãn Toàn Thân">
                    @error('name') <p class="mt-1 text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Danh mục</label>
                    <select name="category_id" 
                            class="w-full px-5 py-4 border border-slate-200 rounded-2xl focus:outline-none focus:border-pink-300 focus:ring-pink-100">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="mt-1 text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Giá (VNĐ)</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price') }}" 
                           class="w-full px-5 py-4 border border-slate-200 rounded-2xl focus:outline-none focus:border-pink-300 focus:ring-pink-100">
                    @error('price') <p class="mt-1 text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Thời lượng (phút)</label>
                    <input type="number" name="duration" value="{{ old('duration') }}" 
                           class="w-full px-5 py-4 border border-slate-200 rounded-2xl focus:outline-none focus:border-pink-300 focus:ring-pink-100">
                    @error('duration') <p class="mt-1 text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Số slot tối đa</label>
                    <input type="number" name="max_slot" value="{{ old('max_slot') }}" 
                           class="w-full px-5 py-4 border border-slate-200 rounded-2xl focus:outline-none focus:border-pink-300 focus:ring-pink-100">
                    @error('max_slot') <p class="mt-1 text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mt-6">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Mô tả ngắn</label>
                <textarea name="short_description" rows="3" 
                          class="w-full px-5 py-4 border border-slate-200 rounded-2xl focus:outline-none focus:border-pink-300 focus:ring-pink-100">{{ old('short_description') }}</textarea>
                @error('short_description') <p class="mt-1 text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mt-6">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Mô tả chi tiết</label>
                <textarea name="long_description" rows="6" 
                          class="w-full px-5 py-4 border border-slate-200 rounded-2xl focus:outline-none focus:border-pink-300 focus:ring-pink-100">{{ old('long_description') }}</textarea>
                @error('long_description') <p class="mt-1 text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="mt-6">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Hình ảnh dịch vụ</label>
                <input type="file" name="image" accept="image/*" 
                       class="w-full px-5 py-4 border border-slate-200 rounded-2xl focus:outline-none focus:border-pink-300">
                @error('image') <p class="mt-1 text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div class="flex gap-4 mt-10">
                <a href="{{ route('admin.services.index') }}" 
                   class="flex-1 text-center py-4 border border-slate-300 hover:bg-slate-50 rounded-2xl font-medium transition">
                    Quay lại
                </a>
                <button type="submit" 
                        class="flex-1 bg-pink-600 hover:bg-pink-700 text-white py-4 rounded-2xl font-semibold transition shadow-lg shadow-pink-500/30">
                    <i class="fas fa-save mr-2"></i> Lưu dịch vụ
                </button>
            </div>
        </form>
    </div>
</div>
@endsection