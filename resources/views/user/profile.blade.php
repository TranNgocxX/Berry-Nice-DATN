@extends('layouts.app')

@section('title', 'Thông tin cá nhân')

@section('content')
<div class="max-w-3xl mx-auto px-6 py-12">

    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">

        <div class="bg-[#A8BCA1] text-white px-8 py-10 text-center">
            <h1 class="text-3xl font-bold logo-font">Thông tin cá nhân</h1>
            <p class="text-white/80 text-sm mt-2 font-medium">Chăm sóc tài khoản BerryNice của bạn</p>
        </div>

        @if(session('success'))
            <div class="mb-8 bg-emerald-50 border border-emerald-200 text-emerald-700 px-6 py-4 rounded-2xl flex items-center gap-3">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="flex justify-center mb-12">
                <div class="relative group">
                    <div id="avatar-preview-container" class="relative">
                        @if($user->avt)
                            <img src="{{ Storage::url($user->avt) }}" 
                                 id="avatar-preview"
                                 class="w-32 h-32 object-cover rounded-[2.5rem] border-4 border-white shadow-md ring-1 ring-slate-100 mx-auto">
                        @else
                            <div id="avatar-preview" 
                                 class="w-32 h-32 bg-[#DDEAD1] text-[#6B8F71] flex items-center justify-center text-4xl rounded-[2.5rem] border-4 border-white shadow-md mx-auto">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                        
                    <label for="avt" class="absolute -bottom-2 -right-2 bg-[#6B8F71] text-white p-3 rounded-2xl cursor-pointer hover:bg-[#557A5E] shadow-lg transition-all transform hover:scale-110">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <input type="file" id="avt" name="avt" class="hidden" accept="image/*" onchange="previewImage(event)">
                    </label>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">

                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Họ và tên <span class="text-red-400">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                            class="w-full px-6 py-4 bg-white border border-slate-200 rounded-3xl focus:border-[#6B8F71] focus:ring-4 focus:ring-[#6B8F71]/10 outline-none transition-all shadow-sm"
                           required>
                    @error('name') <p class="mt-2 text-red-500 text-xs ml-4 font-medium">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Ngày sinh</label>
                    <input type="date" name="birthday" value="{{ old('birthday', $user->birthday) }}" 
                           class="w-full px-6 py-4 bg-white border border-slate-200 rounded-3xl focus:border-[#6B8F71] focus:ring-4 focus:ring-[#6B8F71]/10 outline-none transition-all shadow-sm">
                    @error('birthday') <p class="mt-2 text-red-500 text-xs ml-4 font-medium">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Email <span class="text-red-400">*</span></label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                           class="w-full px-6 py-4 bg-white border border-slate-200 rounded-3xl focus:border-[#6B8F71] focus:ring-4 focus:ring-[#6B8F71]/10 outline-none transition-all shadow-sm"
                           required>
                    @error('email') <p class="mt-2 text-red-500 text-xs ml-4 font-medium">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Số điện thoại</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" 
                           class="w-full px-6 py-4 bg-white border border-slate-200 rounded-3xl focus:border-[#6B8F71] focus:ring-4 focus:ring-[#6B8F71]/10 outline-none transition-all shadow-sm"
                           placeholder="0xxx xxx xxx">
                    @error('phone') <p class="mt-2 text-red-500 text-xs ml-4 font-medium">{{ $message }}</p> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Địa chỉ thường trú</label>
                    <textarea name="address" rows="3"
                              class="w-full px-6 py-4 bg-white border border-slate-200 rounded-3xl focus:border-[#6B8F71] focus:ring-4 focus:ring-[#6B8F71]/10 outline-none transition-all shadow-sm">{{ old('address', $user->address) }}</textarea>
                    @error('address') <p class="mt-2 text-red-500 text-xs ml-4 font-medium">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mt-12">
                <button type="submit" 
                        class="w-full bg-[#6B8F71] hover:bg-[#557A5E] text-white py-5 rounded-3xl text-lg font-bold transition-all shadow-lg shadow-[#6B8F71]/20 hover:shadow-xl active:scale-[0.98]">
                    <i class="fas fa-save mr-2"></i>
                    Lưu thay đổi
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function previewImage(event) {
    const reader = new FileReader();
    const file = event.target.files[0];
    
    if (file) {
        reader.onload = function() {
            const preview = document.getElementById('avatar-preview');
            const classList = "w-32 h-32 object-cover rounded-[2.5rem] border-4 border-white shadow-md ring-1 ring-slate-100 mx-auto";
            
            if (preview.tagName === 'IMG') {
                preview.src = reader.result;
            } else {
                preview.outerHTML = `<img src="${reader.result}" id="avatar-preview" class="${classList}">`;
            }
        }
        reader.readAsDataURL(file);
    }
}
</script>
@endsection