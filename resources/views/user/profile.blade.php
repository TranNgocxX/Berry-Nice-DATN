@extends('layouts.app')
@section('title', 'Thông tin cá nhân')

@section('content')
<div class="max-w-3xl mx-auto px-6 py-12">
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
        
        {{-- Header --}}
        <div class="bg-[#A8BCA1] text-white py-12 text-center">
            <h1 class="text-3xl font-bold logo-font">Thông tin cá nhân</h1>
        </div>

        {{-- Form --}}
        <form id="profile-form" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="px-8 py-10 md:px-16 md:py-14">
            @csrf @method('PUT')

            {{-- Avatar --}}
            <div class="flex justify-center mb-12">
                <div class="relative group">
                    <div id="avatar-preview-container">
                        @php $avatarClass = "w-32 h-32 object-cover rounded-2xl border-4 border-white shadow-md ring-1 ring-slate-100 mx-auto"; @endphp
                        @if($user->avt)
                            <img src="{{ Storage::url($user->avt) }}" id="avatar-preview" class="{{ $avatarClass }}">
                        @else
                            <div id="avatar-preview" class="{{ $avatarClass }} bg-[#DDEAD1] text-[#6B8F71] flex items-center justify-center text-4xl">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <label for="avt" class="absolute -bottom-2 -right-2 bg-[#6B8F71] text-white p-3 rounded-2xl cursor-pointer hover:scale-110 transition-all shadow-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <input type="file" id="avt" name="avt" class="hidden" accept="image/*">
                    </label>
                </div>
            </div>

            {{-- Grid Fields --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-8">
                @php
                    $inputClass = "form-field w-full px-6 py-4 bg-slate-50/50 border border-slate-200 rounded-2xl focus:border-[#6B8F71] focus:ring-4 focus:ring-[#6B8F71]/10 outline-none transition-all";
                    $labelClass = "block text-sm font-bold text-slate-700 mb-2 ml-2";
                @endphp

                <div class="md:col-span-2">
                    <label class="{{ $labelClass }}">Họ và tên <span class="text-red-400">*</span></label>
                    <input type="text" name="name" data-origin="{{ old('name', $user->name) }}" value="{{ old('name', $user->name) }}" class="{{ $inputClass }}" required>
                </div>

                <div>
                    <label class="{{ $labelClass }}">Ngày sinh</label>
                    <input type="date" name="birthday" data-origin="{{ old('birthday', $user->birthday) }}" value="{{ old('birthday', $user->birthday) }}" class="{{ $inputClass }}">
                </div>

                <div>
                    <label class="{{ $labelClass }}">Số điện thoại</label>
                    <input type="text" name="phone" data-origin="{{ old('phone', $user->phone) }}" value="{{ old('phone', $user->phone) }}" placeholder="0xxx xxx xxx" class="{{ $inputClass }}">
                    @error('phone') <p class="text-red-500 text-sm mt-1 ml-2">{{ $message }}</p> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="{{ $labelClass }}">Email <span class="text-red-400">*</span></label>
                    <input type="email" name="email" data-origin="{{ old('email', $user->email) }}" value="{{ old('email', $user->email) }}" class="{{ $inputClass }}" required>
                    @error('email') <p class="text-red-500 text-sm mt-1 ml-2">{{ $message }}</p> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="{{ $labelClass }}">Địa chỉ thường trú</label>
                    <textarea name="address" data-origin="{{ old('address', $user->address) }}" rows="3" class="{{ $inputClass }}">{{ old('address', $user->address) }}</textarea>
                </div>
            </div>

            {{-- Nút Submit: Mặc định màu xám nhạt (Chưa đổi), hiệu ứng active/hover chỉ chạy khi nút sẵn sàng --}}
            <button type="submit" id="submit-btn" disabled
                class="w-full mt-12 py-5 rounded-xl text-lg font-bold transition-all duration-300 outline-none
                       bg-slate-100 text-slate-400 cursor-not-allowed
                       data-[active=true]:bg-[#6B8F71] data-[active=true]:text-white data-[active=true]:hover:bg-[#557A5E] data-[active=true]:cursor-pointer data-[active=true]:shadow-lg data-[active=true]:shadow-[#6B8F71]/20 data-[active=true]:active:scale-[0.98]">
                Cập nhật thông tin
            </button>
        </form>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById('profile-form');
    const btn = document.getElementById('submit-btn');
    const fileInput = document.getElementById('avt');

    // Bật nút khi có bất kỳ thay đổi nào
    function activateButton() {
        btn.disabled = false;
        btn.setAttribute('data-active', 'true');
    }

    // Input / select / textarea
    form.addEventListener('input', activateButton);
    form.addEventListener('change', activateButton);

    // Preview avatar + activate button
    fileInput.addEventListener('change', function (e) {
        activateButton();

        const file = e.target.files[0];
        if (!file) return;

        const reader = new FileReader();

        reader.onload = function () {
            const preview = document.getElementById('avatar-preview');

            const imgClass = "w-32 h-32 object-cover rounded-xl border-4 border-white shadow-md ring-1 ring-slate-100 mx-auto";

            if (preview.tagName === 'IMG') {
                preview.src = reader.result;
            } else {
                preview.outerHTML = `<img src="${reader.result}" id="avatar-preview" class="${imgClass}">`;
            }
        };

        reader.readAsDataURL(file);
    });
});
</script>

@endsection