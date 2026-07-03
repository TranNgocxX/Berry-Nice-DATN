@extends('layouts.admin')
@section('title', 'Sửa thông tin nhân viên')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-800">Sửa thông tin nhân viên</h1>
        <p class="text-slate-500">{{ $employee->name }}</p>
    </div>

    <div class="bg-white rounded-3xl shadow-sm p-8">
        <form action="{{ route('admin.employees.update', $employee) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Họ và tên</label>
                    <input type="text" name="name" value="{{ old('name', $employee->name) }}" 
                           class="w-full px-5 py-4 border border-slate-200 rounded-2xl focus:outline-none focus:border-pink-300 focus:ring-4 focus:ring-pink-100">
                    @error('name') <p class="mt-1 text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Số điện thoại</label>
                    <input type="text" name="phone" value="{{ old('phone', $employee->phone) }}" 
                           class="w-full px-5 py-4 border border-slate-200 rounded-2xl focus:outline-none focus:border-pink-300 focus:ring-4 focus:ring-pink-100">
                    @error('phone') <p class="mt-1 text-red-500 text-sm">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email', $employee->email) }}" 
                           class="w-full px-5 py-4 border border-slate-200 rounded-2xl focus:outline-none focus:border-pink-300 focus:ring-4 focus:ring-pink-100">
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
                               {{ $employee->services->contains($service->id) ? 'checked' : '' }}
                               class="w-5 h-5 text-pink-600 rounded-lg focus:ring-pink-300">
                        <span class="text-slate-700">{{ $service->name }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <div class="flex gap-4 mt-10">
                <a href="{{ route('admin.employees.index') }}" 
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