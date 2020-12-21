<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Services\Cart;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function processOrder()
    {
        //envia a crear una tarjeta si no tiene metodo de pago o tarjeta
        if ( !auth()->user()->hasPaymentMethod() ) {
            return redirect( route('billing.credit_card_form') )
                ->with('status', 'Debes crear un metodo de pago antes de procesar el pedido.');
        }

        $order = null;

        try {
            \DB::beginTransaction();

            $cart = new Cart;
            if (!$cart->hasProducts()) {
                return back()->with('status', 'No hay productos para procesar el pago');
            }

            //guardar los datos del pedido en order
            $order = new Order;
            $order->user_id = auth()->id();
            $order->paid = 'PENDIENTE';
            $order->total_amount = $cart->totalAmount();

            $order->save();

            //guardar el contenido del carrito en el detalle de la orden OrderDetails

            $orderDetail = [];
            foreach ($cart->getContent() as $product) {
                $orderDetail[] = [
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'price' => $product->price,
                    'created_at' =>now()
                ];
            }

            //el metodo insert nos permite guardar un array de array
            OrderDetail::insert($orderDetail);

            \DB::commit();


            //  crear el cargo en stripe, generando una factura
            //  para este cliente
            auth()->user()->invoiceFor('Compra de productos', $order->total_amount * 100, [], [
                'tax_percent' => env('STRIPE_TAXES'),
            ]);


            $cart->clear();

            return redirect('/home')->with('status', 'Muchas gracias por tu compra');

        } catch (\Exception $exception) {
            \DB::rollBack();
            return back()->with('status', $exception->getMessage());
        }

    }
}
