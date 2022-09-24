<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Termwind\Components\Dd;

class ShopController extends Controller
{
    const PRICE_SORT = [
        'low_high' => 'asc',
        'high_low' => 'desc',
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::select('name', 'slug')->get();

        if (request()->category) {
           if (request()->sort) {
               $products = Product::with('categories')->whereHas('categories', function ($query) {
                   $query->where('slug', request()->category);
               })->orderBy('price', self::PRICE_SORT[request()->sort])->get(['name', 'slug', 'price', 'image']);
           } else {
               $products = Product::with('categories')->whereHas('categories', function ($query) {
                   $query->where('slug', request()->category);
               })->get(['name', 'slug', 'price', 'image']);
           }
           $categoryName = optional($categories->where('slug', request()->category)->first())->name;
           $categorySlug = request()->category;

        } else {
            $products = Product::inRandomOrder()->get(['name', 'slug', 'price', 'image']);
            $categorySlug = '';
        }

        return Inertia::render('Shop/index', [
            'products' => $products,
            'categories' => $categories,
            'categoryName' => $categoryName ?? 'All',
            'categorySlug' => $categorySlug,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return Inertia::render('Shop/show', [
            'product' => $product,
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
