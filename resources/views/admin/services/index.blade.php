@extends('layouts.admin')

@section('title', 'Danh sách dịch vụ')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Danh sách dịch vụ</h1>
            <p class="text-slate-500 mt-1">Quản lý tất cả dịch vụ Spa</p>
        </div>
        <a href="{{ route('admin.services.create') }}" 
           class="bg-pink-600 hover:bg-pink-700 text-white px-5 py-3 rounded-xl flex items-center gap-2 font-medium transition shadow-lg shadow-pink-500/30">
            <i class="fas fa-plus"></i>
            Thêm dịch vụ mới
        </a>
    </div>

    {{-- Tìm kiếm --}}
    <div class="mb-6">
        <form action="{{ route('admin.services.index') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3 w-full">
            
            {{-- Nhập từ khóa --}}
            <div class="relative w-full sm:max-w-md">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-slate-400">
                    <i class="fas fa-search text-sm"></i>
                </span>
                <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Tìm kiếm dịch vụ..."
                    class="w-full pl-11 pr-4 py-3 border border-slate-200 rounded-2xl bg-white text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition">
            </div>

            {{-- Chọn Danh mục --}}
            <div class="w-full sm:max-w-xs relative">
                <select name="category_id" onchange="this.form.submit()"
                    class="w-full pl-4 pr-10 py-3 border border-slate-200 rounded-2xl bg-white text-sm text-slate-700 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition cursor-pointer appearance-none">
                    <option value="">— Tất cả danh mục —</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                <span class="absolute inset-y-0 right-4 flex items-center pointer-events-none text-slate-400 text-xs">
                    <i class="fas fa-chevron-down"></i>
                </span>
            </div>

            {{-- Nút Reset --}}
            @if(request('keyword') || request('category_id'))
                <a href="{{ route('admin.services.index') }}" 
                class="w-full sm:w-auto text-center bg-slate-100 hover:bg-red-50 hover:text-red-600 text-slate-500 text-sm font-medium px-5 py-3 rounded-2xl transition whitespace-nowrap">
                    Xóa bộ lọc
                </a>
            @endif

        </form>
    </div>

    <div class="bg-white rounded-3xl shadow-sm overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="border-b border-slate-200 bg-slate-50">
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase">ID</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase">Tên dịch vụ</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase">Loại</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase">Thời lượng</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase">Slot</th>
                    <th class="px-6 py-4 text-right text-xs font-semibold text-slate-500 uppercase">Giá</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase">Ảnh</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase w-40">Hành động</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($services as $service)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-5 font-medium text-slate-800">{{ $service->id }}</td>
                    <td class="px-6 py-5 font-medium text-slate-800">{{ $service->name }}</td>
                    <td class="px-6 py-5 text-slate-600">{{ $service->category->name ?? '—' }}</td>
                    <td class="px-6 py-5 text-center">{{ $service->duration }} phút</td>
                    <td class="px-6 py-5 text-center font-medium">{{ $service->max_slot }}</td>
                    <td class="px-6 py-5 text-right font-semibold text-emerald-600">{{ number_format($service->price) }}đ</td>
                    <td class="px-6 py-5 text-center">
                        @if($service->image)
                            <img src="{{ asset('storage/'.$service->image) }}" 
                                 class="w-16 h-16 object-cover rounded-2xl shadow-sm mx-auto">
                        @else
                            <span class="text-slate-300 text-2xl">📷</span>
                        @endif
                    </td>
                    <td class="px-6 py-5">
                        <div class="flex items-center justify-center gap-3">
                            <a href="{{ route('admin.services.show', $service) }}" 
                            class="flex items-center justify-center w-9 h-9 bg-indigo-100 hover:bg-indigo-200 text-indigo-600 rounded-2xl transition"
                            title="Xem chi tiết">
                                <i class="fas fa-eye"></i>
                            </a>

                            <a href="{{ route('admin.services.edit', $service) }}" 
                            class="flex items-center justify-center w-9 h-9 bg-amber-100 hover:bg-amber-200 text-amber-600 rounded-2xl transition">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.services.destroy', $service) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Bạn có chắc muốn xóa dịch vụ này?')" 
                                        class="flex items-center justify-center w-9 h-9 bg-red-100 hover:bg-red-200 text-red-600 rounded-2xl transition">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @if($services->hasPages())
            <div class="px-6 py-5 border-t border-slate-100">
                {{ $services->links('pagination::tailwind') }}
            </div>
        @endif
    </div>
</div>
@endsection

