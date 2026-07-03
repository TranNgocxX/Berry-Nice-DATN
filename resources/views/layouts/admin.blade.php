<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Spa System</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body { font-family: 'Inter', sans-serif; }
        .sidebar-link:hover { background: #334155; }
        .active-nav { background: #f472b6 !important; color: white !important; }
        .custom-scroll::-webkit-scrollbar { width: 4px; }
        .custom-scroll::-webkit-scrollbar-thumb { background: #475569; border-radius: 10px; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800">

<div class="flex h-screen overflow-hidden">
    
    <aside class="w-64 bg-slate-900 text-slate-300 flex flex-col shadow-xl z-20">
        <div class="p-5 flex items-center justify-center border-b border-slate-800">
            <span class="text-xl font-bold text-white tracking-tight">BERRY NICE</span>
        </div>

        <nav class="flex-1 mt-4 px-3 custom-scroll overflow-y-auto space-y-1">
            
            <p class="px-4 py-2 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Tổng quan</p>
            
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link flex items-center px-4 py-3 rounded-md transition {{ request()->is('admin/dashboard*') ? 'active-nav' : '' }}">
                <i class="fas fa-chart-pie w-5"></i>
                <span class="ml-3 text-sm font-medium">Thống kê số liệu</span>
            </a>

            <p class="px-4 py-2 mt-4 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Quản lý chính</p>

            <a href="{{ route('admin.categories.index') }}" class="sidebar-link flex items-center px-4 py-3 rounded-md transition {{ request()->is('admin/categories*') ? 'active-nav' : '' }}">
                <i class="fas fa-layer-group w-5"></i>
                <span class="ml-3 text-sm font-medium">Danh mục</span>
            </a>

            <a href="{{ route('admin.services.index') }}" class="sidebar-link flex items-center px-4 py-3 rounded-md transition {{ request()->is('admin/services*') ? 'active-nav' : '' }}">
                <i class="fas fa-magic w-5"></i>
                <span class="ml-3 text-sm font-medium">Dịch vụ Spa</span>
            </a>

            <a href="{{ route('admin.employees.index') }}" class="sidebar-link flex items-center px-4 py-3 rounded-md transition {{ request()->is('admin/employees*') ? 'active-nav' : '' }}">
                <i class="fas fa-user-friends w-5"></i>
                <span class="ml-3 text-sm font-medium">Đội ngũ nhân viên</span>
            </a>

            <a href="{{ route('admin.appointments.index') }}" class="sidebar-link flex items-center px-4 py-3 rounded-md transition {{ request()->is('admin/appointments*') ? 'active-nav' : '' }}">
                <i class="fas fa-clock w-5"></i>
                <span class="ml-3 text-sm font-medium">Lịch hẹn</span>
            </a>

            <p class="px-4 py-2 mt-4 text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Tài khoản</p>

            <a href="{{ route('profile.index') }}" class="sidebar-link flex items-center px-4 py-3 rounded-md transition {{ request()->is('admin/profile*') ? 'active-nav' : '' }}">
                <i class="fas fa-id-card w-5"></i>
                <span class="ml-3 text-sm font-medium">Hồ sơ của tôi</span>
            </a>

        </nav>

        <div class="p-4 border-t border-slate-800">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center px-4 py-3 text-red-400 hover:bg-red-500/10 rounded-md transition group">
                    <i class="fas fa-sign-out-alt w-5 group-hover:translate-x-1 transition-transform"></i>
                    <span class="ml-3 text-sm font-semibold">Đăng xuất</span>
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-1 flex flex-col min-w-0">
    <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-8 shadow-sm">
        
        <!-- tìm kiếm -->
        <form action="{{ url()->current() }}" method="GET" class="relative group">
            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-pink-500 transition-colors"></i>
            <input 
                type="text" 
                name="keyword"
                value="{{ request('keyword') }}"
                placeholder="Tìm kiếm..."
                class="w-64 md:w-80 pl-10 pr-4 py-2 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-pink-400 focus:border-transparent text-sm transition-all"
            >
        </form>

        <!-- TTCN -->
        <div class="flex items-center space-x-4 border-l border-slate-100 pl-6">
            <div class="text-right hidden sm:block">
                <p class="text-sm font-bold text-slate-800 leading-tight">{{ auth()->user()->name }}</p>
                <span class="text-[10px] text-pink-600 font-bold uppercase tracking-tighter">Quản trị viên</span>
            </div>

            <img 
                class="h-10 w-10 rounded-full object-cover ring-2 ring-pink-50" 
                src="{{ auth()->user()->avt ? asset('storage/' . auth()->user()->avt) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=f472b6&color=fff' }}" 
                alt="{{ auth()->user()->name }}"
            >
        </div>

    </header>

        <main class="flex-1 overflow-y-auto p-8">
            <!-- Thông báo Toast -->
            @if(session('success'))
            <div id="toast-success" class="fixed top-5 right-5 z-50 flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-2xl shadow-2xl border-l-4 border-green-500 transform transition-all duration-500 translate-x-0" role="alert">
                <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg">
                    <i class="fas fa-check"></i>
                </div>
                <div class="ml-3 text-sm font-bold text-slate-700">{{ session('success') }}</div>
                <button type="button" onclick="this.parentElement.remove()" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg p-1.5 inline-flex h-8 w-8">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <script>
                setTimeout(() => {
                    const toast = document.getElementById('toast-success');
                    if(toast) {
                        toast.style.opacity = '0';
                        toast.style.transform = 'translateX(100px)';
                        setTimeout(() => toast.remove(), 500);
                    }
                }, 4000);
            </script>
            @endif

            @if(session('error'))
                <div id="toast-error"
                    class="fixed top-5 right-5 z-50 flex items-center w-full max-w-md p-4 text-gray-500 bg-white rounded-2xl shadow-2xl border-l-4 border-red-500 transform transition-all duration-500 translate-x-0"
                    role="alert">

                    <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg">
                        <i class="fas fa-circle-exclamation"></i>
                    </div>

                    <div class="ml-3 text-sm font-bold text-slate-700">
                        {{ session('error') }}
                    </div>

                    <button type="button"
                        onclick="this.parentElement.remove()"
                        class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg p-1.5 inline-flex h-8 w-8">
                        <i class="fas fa-times"></i>
                    </button>

                </div>

                <script>
                setTimeout(() => {
                    const toast = document.getElementById('toast-error');
                    if (toast) {
                        toast.style.opacity = '0';
                        toast.style.transform = 'translateX(100px)';
                        setTimeout(() => toast.remove(), 500);
                    }
                }, 4000);
                </script>
                @endif

            <div class="content-body">
                @yield('content')
            </div>
        </main>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const flash = document.querySelector('.bg-white.border-l-4');
        if (flash) {
            setTimeout(() => {
                flash.style.opacity = '0';
                flash.style.transition = '0.5s';
                setTimeout(() => flash.remove(), 500);
            }, 3000);
        }
    });
</script>

</body>
</html>