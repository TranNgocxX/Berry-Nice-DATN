<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-[#F8FAF8] flex items-center justify-center p-6">

<div class="w-full max-w-md bg-white rounded-3xl shadow-xl p-8">

    {{-- Logo --}}
    <div class="text-center mb-8">
        <h1 class="text-4xl font-bold text-[#6B8F71]"> BerryNice </h1>

        <p class="text-slate-500 mt-2"> Chào mừng bạn quay trở lại </p>
    </div>

    @if(session('error'))
        <div class="mb-5 rounded-xl bg-red-50 border border-red-200 text-red-600 px-4 py-3 text-sm">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="/login" class="space-y-5">
        @csrf

        {{-- Email --}}
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">
                Email
            </label>

            <input
                type="email" name="email" value="{{ old('email') }}" placeholder="Nhập email"

                class="w-full rounded-xl border px-4 py-3 focus:outline-none focus:ring-2
                {{ $errors->has('email')
                    ? 'border-red-400 focus:ring-red-200'
                    : 'border-slate-300 focus:border-[#6B8F71] focus:ring-[#A8BCA1]' }}">
        </div>

        @error('email')
            <p class="text-sm text-red-500 -mt-3">{{ $message }}</p>
        @enderror

        {{-- Password --}}
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">
                Mật khẩu
            </label>

            <input
                type="password" name="password" placeholder="Nhập mật khẩu" class="w-full rounded-xl border px-4 py-3 focus:outline-none focus:ring-2
                {{ $errors->has('password')
                    ? 'border-red-400 focus:ring-red-200'
                    : 'border-slate-300 focus:border-[#6B8F71] focus:ring-[#A8BCA1]' }}">
        </div>

        @error('password')
            <p class="text-sm text-red-500 -mt-3">{{ $message }}</p>
        @enderror

        <button
            type="submit" class="w-full rounded-xl bg-[#6B8F71] py-3 text-white font-semibold hover:bg-[#557A5E] transition">
            Đăng nhập
        </button>
    </form>

    <div class="mt-6 text-center text-sm text-slate-500">
        Chưa có tài khoản?
        <a href="/register" class="font-semibold text-[#6B8F71] hover:underline">
            Đăng ký ngay
        </a>
    </div>

</div>

</body>
</html>