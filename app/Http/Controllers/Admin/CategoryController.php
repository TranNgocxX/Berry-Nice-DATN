<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\CategoryRequest;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        // Lấy keyword từ query string
        $keyword = $request->keyword;

        $categories = Category::when($keyword, function ($query) use ($keyword) {
            $query->where('name', 'like', "%{$keyword}%")
                ->orWhere('description', 'like', "%{$keyword}%");
        })
            ->latest()
            ->paginate(10)
            ->appends(['keyword' => $keyword]); // Giữ nguyên keyword trong pagination links

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(CategoryRequest $request)
    {
        Category::create([
            'name' => $request->name,
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
        $category->update([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Cập nhật danh mục thành công');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Xóa thành công');
    }
}
