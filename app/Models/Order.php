<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = ['event_id', 'event_date', 'ticket_adult_price', 'ticket_adult_quantity', 'ticket_kid_price', 'ticket_kid_quantity', 'barcode'];
}
