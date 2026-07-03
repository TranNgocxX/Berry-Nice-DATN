@extends('layouts.admin')

@section('title', 'Danh sách danh mục')

@section('content')
<div class="max-w-7xl mx-auto">

    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800"> Danh sách danh mục </h1>
            <p class="text-slate-500 mt-1"> Quản lý các danh mục dịch vụ Spa </p>
        </div>

        <a href="{{ route('admin.categories.create') }}"
            class="bg-pink-600 hover:bg-pink-700 text-white px-5 py-3 rounded-xl flex items-center gap-2 font-medium transition shadow-lg shadow-pink-500/30">
            <i class="fas fa-plus"></i> Thêm danh mục mới
        </a>
    </div>

    {{-- Tìm kiếm --}}
    <div class="mb-6 flex items-center justify-between gap-4">

        <form action="{{ route('admin.categories.index') }}"
            method="GET"
            class="relative w-full max-w-md">

            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                <i class="fas fa-search text-slate-400 text-sm"></i>
            </div>

            <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Tìm kiếm danh mục..."
                class="w-full pl-11 pr-24 py-3 border border-slate-200 rounded-2xl bg-white text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:border-transparent transition">

            @if(request('keyword'))
                <a href="{{ route('admin.categories.index') }}"
                    class="absolute right-3 top-1/2 -translate-y-1/2 text-sm text-slate-400 hover:text-red-500 transition">
                    Xóa
                </a>
            @endif

        </form>

    </div>

    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

        <table class="w-full">
            <thead>
                <tr class="border-b border-slate-200 bg-slate-50">
                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase w-16">
                        ID
                    </th>

                    <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase w-24">
                        Logo
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase">
                        Tên danh mục
                    </th>

                    <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase">
                        Mô tả
                    </th>

                    <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase w-48">
                        Hành động
                    </th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-100">

                @forelse($categories as $category)
                    <tr class="hover:bg-slate-50 transition">

                        <td class="px-6 py-4 text-slate-500 font-medium">
                            #{{ $category->id }}
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex justify-center">
                                @if($category->logo)
                                    <img src="{{ asset('storage/'.$category->logo) }}"
                                        class="w-14 h-14 rounded-xl object-cover border border-slate-200 shadow-sm">
                                @else
                                    <div class="w-14 h-14 rounded-xl bg-slate-100 flex items-center justify-center border border-dashed border-slate-300">
                                        <i class="fas fa-spa text-pink-400 text-xl"></i>
                                    </div>
                                @endif
                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <div class="font-semibold text-slate-800"> {{ $category->name }} </div>
                        </td>

                        <td class="px-6 py-4 text-sm text-slate-600"> {{ Str::limit($category->description) }} </td>

                        <td class="px-6 py-4">
                            <div class="flex justify-center gap-3">
                                <a href="{{ route('admin.categories.edit',$category) }}"
                                    class="flex items-center justify-center w-9 h-9 bg-amber-100 hover:bg-amber-200 text-amber-600 rounded-xl transition">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form
                                    action="{{ route('admin.categories.destroy',$category) }}"
                                    method="POST">

                                    @csrf @method('DELETE')
                                    <button
                                        onclick="return confirm('Bạn có chắc muốn xóa danh mục này?')"
                                        class="flex items-center justify-center w-9 h-9 bg-red-100 hover:bg-red-200 text-red-600 rounded-xl transition">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>

                            </div>
                        </td>

                    </tr>

                @empty
                    <tr> <td colspan="5" class="py-10 text-center text-slate-400"> Chưa có danh mục nào. </td> </tr>
                @endforelse

            </tbody>

        </table>

        @if($categories->hasPages())
            <div class="px-6 py-4 border-t border-slate-100">
                {{ $categories->links('pagination::tailwind') }}
            </div>
        @endif

    </div>

</div>
@endsection