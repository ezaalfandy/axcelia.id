<?php

namespace App\Services;

class PurchaseServices{
    public static $totalCost = 0;
    public static function sumTotalCost($shoppingCarts, $courierCost = 0){
        foreach ($shoppingCarts as $v) {
            self::$totalCost += ($v->quantity * $v->product->price);
        }
        return self::$totalCost + $courierCost;
    }
}
