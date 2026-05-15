@extends('layouts.admin')

@section('title', 'Danh sách nhân viên')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Danh sách nhân viên</h1>
            <p class="text-slate-500 mt-1">Quản lý đội ngũ nhân viên Spa</p>
        </div>
        <a href="{{ route('admin.employees.create') }}" 
           class="bg-pink-600 hover:bg-pink-700 text-white px-5 py-3 rounded-xl flex items-center gap-2 font-medium transition shadow-lg shadow-pink-500/30">
            <i class="fas fa-plus"></i>
            Thêm nhân viên mới
        </a>
    </div>

    <div class="mb-6 flex items-center justify-between gap-4"> 
        <form action="{{ route('admin.employees.index') }}" method="GET" class="relative w-full max-w-md">
            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                <i class="fas fa-search text-slate-400 text-sm"></i>
            </div>

            <input
                type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Tìm kiếm nhân viên..."
                class="w-full pl-11 pr-24 py-3 border border-slate-200 rounded-2xl bg-white text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition"
            >

            @if(request('keyword'))
                <a href="{{ route('admin.employees.index') }}"
                class="absolute right-3 top-1/2 -translate-y-1/2 text-sm text-slate-400 hover:text-red-500 transition">
                    Xóa
                </a>
            @endif

        </form> 
    </div>

    <div class="bg-white rounded-3xl shadow-sm overflow-hidden">
        <table class="w-full">
            <thead>
                <tr class="border-b border-slate-200 bg-slate-50">
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Tên nhân viên</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Số điện thoại</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Dịch vụ phụ trách</th>
                    <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider w-44">Hành động</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($employees as $employee)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-5 font-medium text-slate-800">{{ $employee->id }}</td>
                    <td class="px-6 py-5 font-medium text-slate-800">{{ $employee->name }}</td>
                    <td class="px-6 py-5 text-slate-600">{{ $employee->phone }}</td>
                    <td class="px-6 py-5 text-slate-600">{{ $employee->email }}</td>
                    <td class="px-6 py-5">
                        @if($employee->services->count() > 0)
                            <div class="flex flex-wrap gap-2">
                                @foreach($employee->services as $service)
                                    <span class="inline-block px-3 py-1 text-xs font-medium bg-pink-100 text-pink-700 rounded-2xl">
                                        {{ $service->name }}
                                    </span>
                                @endforeach
                            </div>
                        @else
                            <span class="text-slate-400 text-sm italic">Chưa phân công dịch vụ</span>
                        @endif
                    </td>
                    <td class="px-6 py-5">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('admin.employees.edit', $employee) }}" 
                               class="flex items-center justify-center w-9 h-9 bg-amber-100 hover:bg-amber-200 text-amber-600 rounded-2xl transition">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.employees.destroy', $employee) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Bạn có chắc muốn xóa nhân viên này?')" 
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

        @if($employees->hasPages())
            <div class="px-6 py-5 border-t">
                {{ $employees->links('pagination::tailwind') }}
            </div>
        @endif
    </div>
</div>
@endsection