<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Category;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword;
        $categories = Category::all();

        $services = Service::with('category')
            ->when($keyword, function ($query, $keyword) {
                $query->where('name', 'like', "%{$keyword}%");
            })
            ->latest()->paginate(9); 

        return view('user.services.index', compact('services', 'categories', 'keyword'));
    }

    // Hiển thị theo danh mục
    public function byCategory($id)
    {
        $category = Category::findOrFail($id);

        $services = Service::where('category_id', $id)
            ->latest()->paginate(9);

        $categories = Category::all();

        return view('user.services.category', compact('category', 'services', 'categories'));
    }

    public function show($id)
    {
        $service = Service::with(['category', 'employees'])->findOrFail($id);
        $categories = Category::all();
        return view('user.services.show', compact('service', 'categories'));
    }
}
