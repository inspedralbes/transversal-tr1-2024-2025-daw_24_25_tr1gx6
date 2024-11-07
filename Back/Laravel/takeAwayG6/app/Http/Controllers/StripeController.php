<?php

namespace App\Http\Controllers;

use Illuminate\Container\Attributes\Auth;
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

        dd($data);


        //$stripe = Stripe::retrieve($data['']);
        $charge = Charge::retrieve($data['']);
    }

    public function verificarUser(Request $request){

        $user = Auth::loginUsingId($request->user_id);

        $intent = $user->createSetupIntent();
        
        return response()->json([]);
    }
}
