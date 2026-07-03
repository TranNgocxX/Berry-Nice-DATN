@extends('layouts.admin')

@section('title', 'Sửa dịch vụ')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Sửa dịch vụ</h1>
        <p class="text-slate-500">{{ $service->name }}</p>
    </div>

    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-600 rounded-2xl text-sm">
            <p class="font-semibold mb-1">Đã có lỗi xảy ra, vui lòng kiểm tra lại:</p>
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-3xl shadow-sm p-8">
        <form action="{{ route('admin.services.update', $service) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Thôg tin -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Tên dịch vụ</label>
                    <input type="text" name="name" value="{{ old('name', $service->name) }}" 
                           class="w-full px-5 py-4 border border-slate-200 rounded-2xl focus:outline-none focus:border-pink-300 focus:ring-pink-100">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Danh mục</label>
                    <select name="category_id" class="w-full px-5 py-4 border border-slate-200 rounded-2xl focus:outline-none focus:border-pink-300 focus:ring-pink-100">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $service->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Giá (VNĐ)</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price', $service->price) }}" 
                           class="w-full px-5 py-4 border border-slate-200 rounded-2xl focus:outline-none focus:border-pink-300 focus:ring-pink-100">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Thời lượng (phút)</label>
                    <input type="number" name="duration" value="{{ old('duration', $service->duration) }}" 
                           class="w-full px-5 py-4 border border-slate-200 rounded-2xl focus:outline-none focus:border-pink-300 focus:ring-pink-100">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Số slot tối đa</label>
                    <input type="number" name="max_slot" value="{{ old('max_slot', $service->max_slot) }}" 
                           class="w-full px-5 py-4 border border-slate-200 rounded-2xl focus:outline-none focus:border-pink-300 focus:ring-pink-100">
                </div>
            </div>

            <div class="mt-6">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Mô tả ngắn</label>
                <textarea name="short_description" rows="3" class="w-full px-5 py-4 border border-slate-200 rounded-2xl focus:outline-none focus:border-pink-300 focus:ring-pink-100">{{ old('short_description', $service->short_description) }}</textarea>
            </div>

            <div class="mt-6">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Mô tả chi tiết</label>
                <textarea name="long_description" rows="6" class="w-full px-5 py-4 border border-slate-200 rounded-2xl focus:outline-none focus:border-pink-300 focus:ring-pink-100">{{ old('long_description', $service->long_description) }}</textarea>
            </div>

            <div class="mt-8">
                <label class="block text-sm font-semibold text-slate-700 mb-2">Hình ảnh hiện tại</label>
                @if($service->image)
                    <img src="{{ asset('storage/' . $service->image) }}" 
                         class="w-48 h-48 object-cover rounded-2xl shadow-md mb-4">
                @endif
                <label class="block text-sm font-semibold text-slate-700 mb-2">Chọn ảnh mới (nếu muốn thay)</label>
                <input type="file" name="image" accept="image/*" 
                       class="w-full px-5 py-4 border border-slate-200 rounded-2xl focus:outline-none focus:border-pink-300">
            </div>

            <div class="flex gap-4 mt-10">
                <a href="{{ route('admin.services.index') }}" 
                   class="flex-1 text-center py-4 border border-slate-300 hover:bg-slate-50 rounded-2xl font-medium transition">
                    Quay lại
                </a>
                <button type="submit" 
                        class="flex-1 bg-pink-600 hover:bg-pink-700 text-white py-4 rounded-2xl font-semibold transition shadow-lg shadow-pink-500/30">
                    <i class="fas fa-save mr-2"></i> Cập nhật dịch vụ
                </button>
            </div>
        </form>
    </div>
</div>
@endsection