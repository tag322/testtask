<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function test() {
        createOrder(1, date('Y-m-d H:i:s'), 1, 1, 1, 1);
    }
}
