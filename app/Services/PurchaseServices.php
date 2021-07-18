<?php

namespace App\Services;

/**
 * Class ini digunakan hanya ketika pembelian saja (tanpa ada perhitungan diskon)
 *
 *
 *
 *
 * */
class PurchaseServices{
    public static $totalCost = 0;
    public static function sumTotalCost($shoppingCarts, $courierCost = 0){
        foreach ($shoppingCarts as $v) {
            self::$totalCost += ($v->quantity * $v->product->price);
        }
        return self::$totalCost + $courierCost;
    }
}
