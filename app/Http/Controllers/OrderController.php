<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function index()
    {
        return Inertia::render('Orders/Index', [
            'orders' => auth()->user()->orders()->with('products')->latest()->paginate(2)
        ]);
    }


    public function show(Order $order)
    {
        return Inertia::render('Orders/Show', [
            'order' => $order->load('products')
        ]);
    }
}
