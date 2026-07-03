<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Requests\Admin\CategoryRequest;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword;

        $categories = Category::when($keyword, function ($query) use ($keyword) {
            $query->where('name', 'like', "%{$keyword}%")
                ->orWhere('description', 'like', "%{$keyword}%");
        })
            ->latest()
            ->paginate(9)
            ->appends(['keyword' => $keyword]); // Giữ nguyên keyword trong pagination links

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(CategoryRequest $request)
    {

        if ($request->hasFile('logo')) {

            $logo = $request->file('logo')
                ->store('categories', 'public');
        }

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name), // Tạo slug từ tên danh mục
            'logo' => $logo ?? null,
            'description' => $request->description
        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Thêm danh mục mới thành công');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(CategoryRequest $request, Category $category)
    {
        $logo = $category->logo; // Giữ nguyên logo cũ nếu không có file mới được tải lên

        if ($request->hasFile('logo')) {
            if ($category->logo) {
                // Xóa logo cũ nếu tồn tại
                Storage::disk('public')->delete($category->logo);
            }

            $logo = $request->file('logo')
                ->store('categories', 'public');
        }
        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'logo' => $logo,
            'description' => $request->description
        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Cập nhật danh mục thành công');
    }

    public function destroy(Category $category)
    {
        if ($category->services()->exists()) {

            return back()
                ->with('error', 'Danh mục đang được sử dụng');
        }

        if ($category->logo) {
            Storage::disk('public')->delete($category->logo);
        }

        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Xóa thành công');
    }
}
