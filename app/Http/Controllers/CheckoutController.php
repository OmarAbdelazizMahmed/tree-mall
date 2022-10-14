<?php

namespace App\Http\Controllers;

use App\Contracts\PaymentGatewayContract;
use App\Http\Requests\CheckoutRequest;
use App\Mail\OrderReceived;
use App\Models\Product;
use App\Models\User;
use App\Services\CartService;
use App\Services\InvoiceService;
use App\Services\OrderService;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Stripe\Exception\CardException;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    protected $cartService;
    protected $orderService;
    protected $paymentGateway;
    protected $invoiceService;

    public function __construct(CartService $cartService, PaymentGatewayContract $paymentGateway, OrderService $orderService, InvoiceService $invoiceService)
    {
        $this->cartService = $cartService;
        $this->paymentGateway = $paymentGateway;
        $this->orderService = $orderService;
        $this->invoiceService = $invoiceService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Cart::instance('default')->count() == 0){
            return redirect()->route('shop.index');
        }
        $cartValues = $this->cartService->setCartValues();
        if (!auth()->check()) {
            return Inertia::render('Checkout/Guest', $cartValues->toArray());
        }
        return Inertia::render('Checkout/Index', $cartValues->toArray());
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
     * @param  \Illuminate\Http\Requests\CheckoutRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CheckoutRequest $request)
    {
        try {
            $user = auth()->user() ??  new User();
            $confirmationNumber = $this->generateConfirmationNumber();

            $order = $user->orders()->create($this->orderService->all($request, $confirmationNumber));

            foreach(Cart::instance('default')->content() as $item) {
                $product = Product::find($item->model->id);
                if ($product->quantity < $item->qty) {
                    if ($product->quantity === 0) {
                        return response([
                            'errors' => 'Sorry! '.$item->name. ' is no longer available. Please remove the item from your cart.'
                        ], 400);
                    }
                    return response([
                        'errors' => 'Sorry! There are only '.$product->quantity. 'of '.$item->name. ' left. Please adjust the quantities in your cart!',
                    ], 400);
                }
                $order->products()->attach($product, ['quantity' => $item->qty]);
                $product->decrement('quantity', $item->qty);
            }

            Cart::instance('default')->destroy();

            if (session()->has('coupon')) {
                session()->forget('coupon');
            }

            $userInvoice = auth()->user() ?? $order->billing_email;

            Mail::to($userInvoice)->send(new OrderReceived($order->load('products'), $this->invoiceService->createInvoice($order)));

            return response([
                'success' => true,
                'order' => [
                    'confirmation_number' => $order->confirmation_number,
                    'billing_discount' => $order->billing_discount,
                    'billing_discount_code' => $order->billing_discount_code,
                    'billing_subtotal' => $order->billing_subtotal,
                    'billing_total' => $order->billing_total,
                    'billing_tax' => $order->billing_tax,
                    'items' => $order->products->map(function ($product) {
                        return [
                            'name' => $product->name,
                            'price' => $product->price,
                            'quantity' => $product->pivot->quantity,
                            'slug' => $product->slug,
                            'main_image' => $product->main_image,
                        ];
                    }),
                ]
            ], 200);
        } catch (CardException $e) {
            return response([
                'errors' => $e->getMessage(),
            ], 500);
        } catch (\Exception $e) {
            return response([
                'errors' => $e->getMessage(),
            ], 500);
        }

    }

    private function generateConfirmationNumber()
    {
        return strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 6));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
