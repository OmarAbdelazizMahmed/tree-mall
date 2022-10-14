<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AlgoliaSearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');

        if ($query) {
            $products = Product::search($query)->get();
        } else {
            $products = Product::latest()->get();
        }

        return Inertia::render('Searches/AlgoliaSearch/Index', [
            'products' => $products,
        ]);
    }
}
