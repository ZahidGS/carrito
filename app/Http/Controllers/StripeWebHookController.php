<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Laravel\Cashier\Http\Controllers\WebhookController;

class StripeWebHookController extends WebhookController
{

    public function handleChargeSucceeded($payload)
    {
        try {

            $user = $this->getUserByStripeId($payload['data']['object']['customer']);

            if ($user) {
                $order = $user->orders()
                    ->where('paid', 'PENDIENTE')
                    ->latest()
                    ->first();

                if ($order) {

                    $order->update([
                        'paid' => 'PAGADO',
                    ]);

                    Log::info(json_encode($user));
                    Log::info(json_encode($order));
                    Log::info("Pedido actualizado correctamente");

                    return new Response('Webhook Handled: {handleChargeSucceeded}', 200);
                }
            }
        } catch (\Exception $exception) {
            Log::debug("Excepción Webhook {handleChargeSucceeded}: " . $exception->getMessage() . ", Line: " . $exception->getLine() . ', File: ' . $exception->getFile());
            return new Response('Webhook Handled with error: {handleChargeSucceeded}', 400);
        }
    }

}
