@extends('layouts.admin')
@section('title', 'Thêm nhân viên mới')

@section('content')
<div class="max-w-7xl mx-auto h-fit">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Thêm mới</h1>
        <p class="text-slate-500">Nhập thông tin nhân viên</p>
    </div>

    <div class="bg-white rounded-3xl shadow-sm p-8">
        <form action="{{ route('admin.employees.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Họ và tên <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" 
                           class="w-full px-5 py-4 border border-slate-200 rounded-2xl focus:outline-none focus:border-pink-300 focus:ring-4 focus:ring-pink-100"
                           placeholder="Nguyễn Thị Lan">
                    @error('name') <p class="mt-1 text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Số điện thoại <span class="text-red-500">*</span></label>
                    <input type="text" name="phone" value="{{ old('phone') }}" 
                           class="w-full px-5 py-4 border border-slate-200 rounded-2xl focus:outline-none focus:border-pink-300 focus:ring-4 focus:ring-pink-100"
                           placeholder="0987654321">
                    @error('phone') <p class="mt-1 text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" 
                           class="w-full px-5 py-4 border border-slate-200 rounded-2xl focus:outline-none focus:border-pink-300 focus:ring-4 focus:ring-pink-100"
                           placeholder="example@spa.com">
                    @error('email') <p class="mt-1 text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mt-8">
                <label class="block text-sm font-semibold text-slate-700 mb-3">Dịch vụ phụ trách</label>
                <div class="grid grid-cols-2 gap-3 max-h-80 overflow-y-auto pr-2">
                    @foreach($services as $service)
                    <label class="flex items-center gap-3 bg-slate-50 hover:bg-slate-100 p-4 rounded-2xl cursor-pointer transition">
                        <input type="checkbox" 
                               name="service_ids[]" 
                               value="{{ $service->id }}"
                               class="w-5 h-5 text-pink-600 rounded-lg focus:ring-pink-300">
                        <span class="text-slate-700">{{ $service->name }}</span>
                    </label>
                    @endforeach
                    @error('service_ids') <p class="mt-1 text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex gap-4 mt-10">
                <a href="{{ route('admin.employees.index') }}" 
                   class="flex-1 text-center py-4 border border-slate-300 hover:bg-slate-50 rounded-2xl font-medium transition">
                    Quay lại
                </a>
                <button type="submit" 
                        class="flex-1 bg-pink-600 hover:bg-pink-700 text-white py-4 rounded-2xl font-semibold transition shadow-lg shadow-pink-500/30">
                    <i class="fas fa-save mr-2"></i> Lưu
                </button>
            </div>
        </form>
    </div>
</div>
@endsection