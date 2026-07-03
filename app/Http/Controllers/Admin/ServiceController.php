<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\ServiceRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();

        $services = Service::with('category')
            ->filter($request->only(['keyword', 'category_id']))
            ->latest()
            ->paginate(9)
            ->withQueryString();

        return view('admin.services.index', compact('services', 'categories'));
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
            'slug' => Str::slug($request->name), // Tạo slug từ tên dịch vụ
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

    public function show(Service $service)
    {
        $service->load('category');
        return view('admin.services.show', compact('service'));
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
            // Xóa ảnh cũ nếu có
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }
            $imagePath = $request->file('image')
                ->store('services', 'public');
        }

        $service->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name), // Tạo slug từ tên dịch vụ
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

        if ($service->appointments()->exists()) {
            return back()
                ->with('error', 'Dịch vụ đang được sử dụng');
        }

        if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }

        $service->delete();

        return redirect()->route('admin.services.index')
            ->with('success', 'Xóa dịch vụ thành công');
    }
}
