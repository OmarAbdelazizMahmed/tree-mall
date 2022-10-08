<?php

namespace App\Http\Controllers;


use App\Models\Order;
use App\Services\InvoiceService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InvoiceController extends Controller
{
    protected $invoiceService;


    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return $this->invoiceService->createInvoice($order)->stream();
    }

    public function store(Request $request)
    {
        $url = route('invoice.show', ['order' => $request->order]);
        return Inertia::location($url);
    }


}
