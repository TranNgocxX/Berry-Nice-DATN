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

        $services = Service::with('category')
            ->filter(['keyword' => $keyword])
            ->latest()
            ->paginate(9)
            ->withQueryString();

        return view('pages.services.index', compact('services', 'keyword'));
    }

    public function byCategory(Category $category)
    {
        // Lấy danh sách DV trực tiếp từ danh mục đó
        $services = $category->services()
            ->latest()
            ->paginate(9);

        return view('pages.services.category', compact('category', 'services'));
    }

    public function show(Service $service)
    {
        $service->load('category');
        return view('pages.services.show', compact('service'));
    }
}
