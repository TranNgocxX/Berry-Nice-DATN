<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Category;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword;

        $services = Service::with('category')
            ->search($keyword) // sd scopeSearch trong model
            ->latest()->paginate(9)->withQueryString();

        return view('user.services.index', compact('services', 'keyword'));
    }

    public function byCategory(Category $category)
    {
        $services = Service::where('category_id', $category->id)
            ->latest()->paginate(9);

        return view('user.services.category', compact('category', 'services'));
    }

    public function show($id)
    {
        $service = Service::with(['category', 'employees'])->findOrFail($id);
        return view('user.services.show', compact('service'));
    }
}
