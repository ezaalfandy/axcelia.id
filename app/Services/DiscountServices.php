<?php
namespace App\Services;
use App\Models\Purchase;
use App\Models\PurchaseDetail;

class DiscountServices{
    public static $totalCost = 0;
    public static function calculateTotalCost($purchase){
        $purchase_details = PurchaseDetail::where('purchase_id', $purchase->id)->get();
        foreach ($purchase_details as $k => $v) {
            self::$totalCost += $v->TotalPrice;
        }

        $purchase->total_cost = self::$totalCost + $purchase->courier_cost;
        $purchase->save();
        return true;
    }
}
