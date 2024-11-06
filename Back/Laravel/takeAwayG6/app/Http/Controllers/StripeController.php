<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;
use Laravel\Cashier\Cashier;


class StripeController extends Controller
{
    public function Compra(Request $request){
        $data = $request->validate([
            'numCard' => 'required',
            'fechaExp' => 'required',
            'CVV' => 'required',
            'titular' => 'required'
        ]);

        
    }
}
