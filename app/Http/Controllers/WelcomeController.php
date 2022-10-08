<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class WelcomeController extends Controller
{

    public function __invoke()
    {
        $categories = Category::select('name', 'slug')->take(4)->get();
        $featured = Product::where('featured', true)->take(4)->select('name', 'slug', 'image')->get();
        return Inertia::render('Welcome', [
            'featured' => $featured,
            'categories' => $categories
        ]);
    }
}
