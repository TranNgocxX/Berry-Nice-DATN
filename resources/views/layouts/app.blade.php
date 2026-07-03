<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BerryNice Spa')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;500;600&family=Poppins:wght@500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body { font-family: 'Inter', sans-serif;}
        .logo-font { font-family: 'Playfair Display', serif;}
        [x-cloak] { display: none !important; }
        
        .avatar-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: inherit;
        }
    </style>
</head>

<body class="bg-[#FDFBF0] text-slate-800">
    <!-- Navbar -->
    <nav class="bg-white shadow-sm sticky top-0 z-50"
         x-data="{ mobileMenu: false, mobileProfile: false }">

        <div class="w-full px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">

                <!-- 1. Menu Mobile Button (bên trái) -->
                <div class="flex md:hidden order-1">
                    <button @click="mobileMenu = !mobileMenu; mobileProfile = false"
                            class="w-10 h-10 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 flex items-center justify-center text-slate-700 transition">
                        <i class="fas fa-bars text-lg" x-show="!mobileMenu"></i>
                        <i class="fas fa-times text-lg" x-show="mobileMenu"></i>
                    </button>
                </div>

                <!-- 2. Logo (Căn giữa trên mobile, bên trái trên desktop) -->
                <div class="flex-shrink-0 order-2 md:order-1">
                    <a href="{{ route('home') }}" class="flex items-center gap-2">
                        <span class="logo-font text-2xl sm:text-3xl font-bold tracking-tight text-slate-800">
                            BerryNice
                        </span>
                    </a>
                </div>

                <!-- 3. Desktop Menu -->
                <div class="hidden md:flex items-center gap-8 lg:gap-12 order-2">
                    <a href="{{ route('home') }}" class="font-medium hover:text-[#557A5E] transition">Trang chủ</a>

                    <div x-data="{ open: false }" class="relative" @click.away="open = false">
                        <button @click="open = !open"
                                class="font-medium flex items-center gap-1 hover:text-[#557A5E] transition focus:outline-none">
                            Dịch vụ
                            <i class="fas fa-chevron-down text-xs transition" :class="{ 'rotate-180': open }"></i>
                        </button>
                        <div x-show="open" x-transition class="absolute left-0 mt-3 bg-white shadow-2xl rounded-2xl py-3 w-56 z-50 border border-slate-100">
                            @foreach($categories as $category)
                                <a href="{{ route('services.category', $category) }}"
                                   class="block px-6 py-3 hover:bg-[#FDFBF0] transition text-sm">
                                    {{ $category->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <a href="{{ route('about') }}" class="font-medium hover:text-[#557A5E] transition">Về chúng tôi</a>
                    <a href="{{ route('faq') }}" class="font-medium hover:text-[#557A5E] transition">Q&A</a>
                    <a href="{{ route('contact') }}" class="font-medium hover:text-[#557A5E] transition">Liên hệ</a>
                </div>

                <!-- 4. Auth & Profile (bên phải) -->
                <div class="flex items-center gap-4 order-3">
                    
                    <!-- Desktop Auth -->
                    <div class="hidden md:block">
                        @guest
                            <a href="{{ route('login') }}"
                               class = "px-5 py-2 rounded-xl bg-[#9CC69B] hover:bg-[#8BB98A] text-white transition font-medium">
                                Đăng nhập
                            </a>
                        @endguest
                    </div>

                    @auth
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" 
                                    class="w-10 h-10 md:w-11 md:h-11 bg-[#DDEAD1] rounded-xl flex items-center justify-center overflow-hidden border border-slate-100 transition-all flex-shrink-0">
                                @if(auth()->user()->avt)
                                    <img src="{{ asset('storage/' . auth()->user()->avt) }}" alt="Avatar" class="avatar-img">
                                @else
                                    <i class="fas fa-user text-[#6B8F71] text-lg"></i>
                                @endif
                            </button>

                            <!-- Dropdown cho cả Desktop và Mobile Profile -->
                            <div x-show="open" x-transition x-cloak @click.away="open = false" 
                                 class="absolute right-0 mt-3 bg-white shadow-2xl rounded-2xl py-2 w-60 z-50 border border-slate-100">
                                <a href="{{ route('profile.index') }}" class="flex items-center gap-3 px-6 py-3 hover:bg-[#FDFBF0] transition">
                                    <i class="fas fa-user-circle text-slate-400"></i>
                                    <span>Thông tin cá nhân</span>
                                </a>
                                <a href="{{ route('bookings.index') }}" class="flex items-center gap-3 px-6 py-3 hover:bg-[#FDFBF0] transition">
                                    <i class="fas fa-calendar-alt text-slate-400"></i>
                                    <span>Lịch của tôi</span>
                                </a>
                                <hr class="my-2 border-slate-100">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-3 px-6 py-3 text-red-600 hover:bg-red-50 transition">
                                        <i class="fas fa-sign-out-alt"></i>
                                        <span>Đăng xuất</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endauth

                    <!-- Đăng nhập (Mobile nếu chưa) -->
                    @guest
                        <div class="md:hidden">
                            <a href="{{ route('login') }}" class="text-green-700 font-medium text-sm">Đăng nhập</a>
                        </div>
                    @endguest
                </div>

            </div>
        </div>

        <!-- Mobile menu -->
        <div x-show="mobileMenu" x-cloak x-transition class="md:hidden bg-white border-t border-slate-100 shadow-lg">
            <div class="px-5 py-5 space-y-2">
                <a href="{{ route('home') }}" class="block py-3 font-medium hover:text-[#6B8F71] transition">Trang chủ</a>
                <div x-data="{ open: false }">
                    <button @click="open = !open" class="w-full py-3 text-left font-medium flex items-center justify-between">
                        <span>Dịch vụ</span>
                        <i class="fas fa-chevron-down text-xs transition" :class="{ 'rotate-180': open }"></i>
                    </button>
                    <div x-show="open" x-transition class="mt-2 space-y-1 pl-4 border-l border-slate-200">
                        @foreach($categories as $category)
                            <a href="{{ route('services.category', $category) }}" class="block py-2 text-slate-600">{{ $category->name }}</a>
                        @endforeach
                    </div>
                </div>
                <a href="{{ route('about') }}" class="block py-3 font-medium">Về chúng tôi</a>
                <a href="{{ route('faq') }}" class="block py-3 font-medium">Q&A</a>
                <a href="{{ route('contact') }}" class="block py-3 font-medium">Liên hệ</a>
            </div>
        </div>

    </nav>

    <main class="relative z-10">
        @yield('content')
    </main>
    
    @include('layouts.footer')

</body>
</html>