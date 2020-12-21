<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BillingController extends Controller
{
    //
    public function creditCardForm()
    {
        return view('billing.credit_card_form');
    }

    public function processCreditCardForm()
    {
        $this->validate(request(), [
            'card_number' => 'required',
            'card_exp_year' => 'required',
            'card_exp_month' => 'required',
            'cvc' => 'required',
        ]);

        try {
            \DB::beginTransaction();

            //se establece el entorno para saber donde debe trabajar
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

            //si no hay metodo de pago, crea un nuevo cliente en Stripe
            if ( ! auth()->user()->hasPaymentMethod()) {
                auth()->user()->createAsStripeCustomer();
            }

            //crear metodo de pago
            $paymentMethod = \Stripe\PaymentMethod::create([
                'type' => 'card',
                'card' => [
                    'number' => request('card_number'),
                    'exp_month' => request('card_exp_month'),
                    'exp_year' => request('card_exp_year'),
                    'cvc' => request('cvc'),
                ]
            ]);

            //actualiza el metodo de pago del usuario
            auth()->user()->updateDefaultPaymentMethod($paymentMethod->id);
            auth()->user()->save();

            \DB::commit();
            return redirect('/home')->with('status','Tarjeta registrada.');

        } catch (\Exception $exception) {
            \DB::rollback();
            return back()->with('status',$exception->getMessage());
        }
    }
}
