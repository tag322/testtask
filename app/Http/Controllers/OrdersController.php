<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use \stdClass;
use Illuminate\Support\Facades\Log;

class OrdersController extends Controller
{
    function RegisterOrder(Request $req) {
        $validated = $req->validate([
            'event_id' => 'required',
            'event_date' => 'required',
            'ticket_adult_price' => 'required',
            'ticket_adult_quantity' => 'required',
            'ticket_kid_price' => 'required',
            'ticket_kid_quantity' => 'required',
        ]);

        $order = createOrder(
            $validated['event_id'],
            $validated['event_date'],
            $validated['ticket_adult_price'],
            $validated['ticket_adult_quantity'],
            $validated['ticket_kid_price'],
            $validated['ticket_kid_quantity'],
        );

        if($order) {
            return response('success', 200);
        }
        return response('error', 500);
    }

    function BookOrder(Request $req) {

        $validated = $req->validate([
            'event_id' => 'required',
            'event_date' => 'required',
            'ticket_adult_price' => 'required',
            'ticket_adult_quantity' => 'required',
            'ticket_kid_price' => 'required',
            'ticket_kid_quantity' => 'required',
            'barcode' => 'required',
        ]);

        $i = 0;
        while($i<3) { // loop requests until response has the 'message' property 

            //example request
            // $response = Http::post('https://api.site.com/book', [
            //     $validated
            // ]);

            $response = new stdClass(); 
            //example response
            rand(1, 2) > 1 ? $response->error = 'barcode already exists' : $response->message = 'order successfully booked'; // 50% for fail & 50% for success

            if(property_exists($response, 'message')) {

                //example request
                // $scnd_response = Http::post('https://api.site.com/approve', [
                //     $validated['barcode']
                // ]);

                $secondResponse = new stdClass(); 
                $errorMsgs = ['event cancelled', 'no tickets', 'no seats', 'fan removed'];
                rand(1,2) > 1 ? $secondResponse->message = 'order successfully aproved' : $secondResponse->error = $errorMsgs[rand(0,3)];

                if(property_exists($secondResponse, 'message')) {
                    
                    try {
                        createOrder(
                            $validated['event_id'],
                            $validated['event_date'],
                            $validated['ticket_adult_price'],
                            $validated['ticket_adult_quantity'],
                            $validated['ticket_kid_price'],
                            $validated['ticket_kid_quantity'],
                            $validated['barcode']
                        );
                    } catch(\Illuminate\Database\QueryException $err) {
                        return 'error: looks like this barcode alreay used';
                    }
                    
                    return 'order successfully booked';
                }

                return $secondResponse->error;
            }

            Log::info('failed attempt');
            $validated['barcode'] = sprintf("%06d", mt_rand(1, 99999999)); //generate new barcode if previous was already used
            $i++;
        }

        return 'something went wrong';
        
    }
}
