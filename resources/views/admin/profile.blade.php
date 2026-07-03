@extends('layouts.admin')

@section('title', 'Thông tin cá nhân')

@section('content')
<div class="min-h-screen bg-gray-50 py-6 px-6">
    <div class="max-w-full mx-auto space-y-6">

        <!-- Header -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Thông tin cá nhân</h1>
                <p class="text-gray-500 mt-1">Quản lý thông tin tài khoản của bạn</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            <!-- Avatar Card -->
            <div class="lg:col-span-4">
                <div class="bg-white rounded-3xl shadow p-8 text-center sticky top-6">
                    <div class="relative w-40 h-40 mx-auto">
                        <div id="avatar-preview" class="w-40 h-40 rounded-3xl overflow-hidden border-4 border-white shadow-md">
                            @if(auth()->user()->avt)
                                <img src="{{ asset('storage/' . auth()->user()->avt) }}" 
                                     alt="Avatar" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-pink-500 to-purple-600 flex items-center justify-center text-6xl text-white font-semibold">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <h2 class="mt-6 text-2xl font-semibold text-gray-800">{{ auth()->user()->name }}</h2>
                    <p class="text-gray-500">{{ auth()->user()->email }}</p>
                    
                    <span class="inline-block mt-3 px-5 py-1.5 bg-pink-100 text-pink-700 text-sm font-medium rounded-2xl">
                        Quản trị viên
                    </span>

                    <label for="avt" 
                           class="mt-8 block text-pink-600 hover:text-pink-700 font-medium cursor-pointer transition">
                            Thay đổi ảnh đại diện
                    </label>
                </div>
            </div>

            <!-- Main -->
            <div class="lg:col-span-8">
                <div class="bg-white rounded-3xl shadow p-8">

                    <h3 class="text-xl font-semibold mb-6 flex items-center gap-3">
                        <i class="fas fa-user-edit text-pink-600"></i>
                        Thông tin chi tiết
                    </h3>

                    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" id="profile-form">
                        @csrf
                        @method('PUT')

                        <!-- Hidden file input -->
                        <input type="file" id="avt" name="avt" accept="image/*" class="hidden" onchange="previewImage(event)">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Họ và tên</label>
                                <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}"
                                       class="w-full px-5 py-3.5 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                                       class="w-full px-5 py-3.5 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Số điện thoại</label>
                                <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone ?? '') }}"
                                       class="w-full px-5 py-3.5 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Ngày sinh</label>
                                <input type="date" name="birthday" value="{{ old('birthday', auth()->user()->birthday ?? '') }}"
                                       class="w-full px-5 py-3.5 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition">
                            </div>
                        </div>

                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Địa chỉ</label>
                            <textarea name="address" rows="3"
                                class="w-full px-5 py-3.5 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition">{{ old('address', auth()->user()->address ?? '') }}</textarea>
                        </div>

                        <div class="mt-8 flex justify-end">
                            <button type="submit"
                                    class="bg-pink-600 hover:bg-pink-700 text-white px-8 py-4 rounded-2xl font-medium flex items-center gap-2 transition shadow-lg shadow-pink-500/30">
                                <i class="fas fa-save"></i>
                                Lưu thay đổi
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Đổi mật khẩu -->
                <div class="mt-6 bg-white rounded-3xl shadow p-8">
                    <h3 class="text-xl font-semibold mb-6 flex items-center gap-3">
                        <i class="fas fa-lock text-pink-600"></i>
                        Đổi mật khẩu
                    </h3>

                    <form action="{{ route('admin.profile.password') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Mật khẩu hiện tại</label>
                                <input type="password" name="current_password" 
                                       class="w-full px-5 py-3.5 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-pink-500">
                            </div>
                            @error('current_password')
                                <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                            @enderror

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Mật khẩu mới</label>
                                <input type="password" name="password" 
                                       class="w-full px-5 py-3.5 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-pink-500">
                            </div>
                            @error('password')
                                <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                            @enderror

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Xác nhận mật khẩu mới</label>
                                <input type="password" name="password_confirmation" 
                                       class="w-full px-5 py-3.5 border border-gray-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-pink-500">
                            </div>
                            @error('password_confirmation')
                                <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                            
                        </div>

                        <div class="mt-8 flex justify-end">
                            <button type="submit"
                                    class="bg-gray-800 hover:bg-gray-900 text-white px-8 py-4 rounded-2xl font-medium transition">
                                Đổi mật khẩu
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function previewImage(event) {
    const reader = new FileReader();
    const preview = document.getElementById('avatar-preview');

    reader.onload = function() {
        preview.innerHTML = `<img src="${reader.result}" class="w-full h-full object-cover">`;
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>
@endsection