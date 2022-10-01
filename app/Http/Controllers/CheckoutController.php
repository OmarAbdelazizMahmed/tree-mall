<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\User;
use App\Services\CartService;
use App\Services\StripPaymentGateway;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Stripe\Exception\CardException;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    protected $cartService;
    protected $paymentGateway;

    public function __construct(CartService $cartService, StripPaymentGateway $paymentGateway)
    {
        $this->cartService = $cartService;
        $this->paymentGateway = $paymentGateway;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cartValues = $this->cartService->setCartValues();
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
            $confirmationNumber = Str::uuid();

            $this->paymentService->charge($user, $confirmationNumber, $request);

            return response([
                'success' => true,
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
