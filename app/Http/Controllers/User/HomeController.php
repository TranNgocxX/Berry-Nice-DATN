<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();

        $featuredServices = Service::with('category')->latest()->take(6)->get();

        return view('user.home', compact('categories', 'featuredServices'));
    }

    public function about()
    {
        return view('user.home.about');
    }

    public function contact()
    {
        return view('user.home.contact');
    }

    public function faq()
    {
        return view('user.home.faq');
    }
}
