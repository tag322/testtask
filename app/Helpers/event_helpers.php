<?php

use App\Models\Order;

function createOrder($event_id, $event_date, $ticket_adult_price, $ticket_adult_quantity, $ticket_kid_price, $ticket_kid_quantity, $barcode = null) {     
    
    if($barcode == null) {
        $barcode = sprintf("%06d", mt_rand(1, 99999999)); #from 00000001 to 99999999
    }

    $order = Order::create([
        'event_id' => $event_id,
        'event_date' => $event_date,
        'ticket_adult_price' => $ticket_adult_price,
        'ticket_adult_quantity' => $ticket_adult_quantity,
        'ticket_kid_price' => $ticket_kid_price,
        'ticket_kid_quantity' => $ticket_kid_quantity,
        'barcode' => $barcode,
    ]);

    return $order;
} 