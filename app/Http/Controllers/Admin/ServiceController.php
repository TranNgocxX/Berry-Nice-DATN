<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\ServiceRequest;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
    $keyword = $request->keyword;

    $services = Service::with('category')
        ->when($keyword, function ($query) use ($keyword) {
            $query->where('name', 'like', "%{$keyword}%")
                  ->orWhere('short_description', 'like', "%{$keyword}%")
                  ->orWhere('long_description', 'like', "%{$keyword}%")
                  ->orWhereHas('category', function ($q) use ($keyword) {
                      $q->where('name', 'like', "%{$keyword}%");
                  });
        })
        ->latest()
        ->paginate(10)
        ->appends([
            'keyword' => $keyword
        ]);

        return view('admin.services.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        return view('admin.services.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ServiceRequest $request)
    {
        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')
                ->store('services', 'public');
        }

        Service::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,
            'image' => $imagePath,
            'duration' => $request->duration,
            'max_slot' => $request->max_slot,
            'price' => $request->price
        ]);

        return redirect()->route('admin.services.index')
            ->with('success', 'Thêm dịch vụ thành công');
    }

    public function show($id)
    {

    }

    public function edit(Service $service)
    {
        $categories = Category::all();

        return view('admin.services.edit', compact('service', 'categories'));
    }

    public function update(ServiceRequest $request, Service $service)
    {
        $imagePath = $service->image;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')
                ->store('services', 'public');
        }

        $service->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,
            'image' => $imagePath,
            'duration' => $request->duration,
            'max_slot' => $request->max_slot,
            'price' => $request->price
        ]);

        return redirect()->route('admin.services.index')
            ->with('success', 'Cập nhật thành công');
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('admin.services.index')
            ->with('success', 'Xóa dịch vụ thành công');
    }

}
