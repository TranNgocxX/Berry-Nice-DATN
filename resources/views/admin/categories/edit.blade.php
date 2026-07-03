@extends('layouts.admin')

@section('title', 'Sửa danh mục')

@section('content')

<div class="max-w-4xl mx-auto">

    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800"> Sửa danh mục </h1>
        <p class="text-slate-500"> {{ $category->name }} </p>
    </div>

    <div class="bg-white rounded-3xl shadow-sm p-8">
        <form
            action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">

            @csrf @method('PUT')

            <div class="mb-6">
                <label class="block text-sm font-semibold text-slate-700 mb-2"> Tên danh mục
                    <span class="text-red-500">*</span>
                </label>

                <input type="text" name="name" value="{{ old('name', $category->name) }}" class="w-full px-5 py-4 border rounded-2xl focus:outline-none transition
                    {{ $errors->has('name')
                        ? 'border-red-500 focus:ring-4 focus:ring-red-100'
                        : 'border-slate-200 focus:border-pink-300 focus:ring-4 focus:ring-pink-100' }}">

                @error('name') <p class="mt-1 text-red-500 text-sm"> {{ $message }} </p> @enderror
            </div>

            {{-- Logo --}}
            <div class="mb-6">
                <label class="block text-sm font-semibold text-slate-700 mb-2"> Logo danh mục </label>

                <div class="flex items-center gap-6">
                    <div>
                        <img
                            id="preview"
                            src="{{ asset('storage/' . ($category->logo ?? 'categories/default-category.png')) }}"
                            class="w-28 h-28 rounded-2xl border border-slate-200 object-cover">
                    </div>

                    <div class="flex-1">
                        <input id="logo" type="file" name="logo" accept="image/*" class="w-full px-4 py-3 border border-slate-200 rounded-2xl">
                        <p class="text-xs text-slate-500 mt-2"> Chọn ảnh mới nếu muốn thay đổi logo </p>

                        @error('logo') <p class="text-red-500 text-sm mt-1"> {{ $message }} </p> @enderror
                    </div>
                </div>

            </div>

            {{-- Mô tả --}}
            <div class="mb-8">
                <label class="block text-sm font-semibold text-slate-700 mb-2"> Mô tả </label>
                <textarea
                    name="description" rows="5"
                    class="w-full px-5 py-4 border border-slate-200 rounded-2xl focus:outline-none focus:border-pink-300 focus:ring-4 focus:ring-pink-100 transition">{{ old('description', $category->description) }}
                </textarea>
            </div>

            <div class="flex gap-4">
                <a href="{{ route('admin.categories.index') }}"
                    class="flex-1 text-center py-4 border border-slate-300 hover:border-slate-400 rounded-2xl font-medium text-slate-600 transition">
                    Quay lại
                </a>

                <button type="submit" class="flex-1 bg-pink-600 hover:bg-pink-700 text-white py-4 rounded-2xl font-semibold transition shadow-lg shadow-pink-500/30">
                    <i class="fas fa-save mr-2"></i>
                    Cập nhật
                </button>
            </div>

        </form>
    </div>

</div>

<script>
document.getElementById('logo').addEventListener('change', function (e) {
    const file = e.target.files[0];
    if (file) {
        document.getElementById('preview').src = URL.createObjectURL(file);
    }
});
</script>

@endsection