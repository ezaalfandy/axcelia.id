<?php

namespace App\Services;


class CourierServices{
    private static $api_key = "e7aba1c27611c9bc51b88b2f0c82246a";
    private static $origin = "4079";
    private static $totalWeight = 0;//in gram

    public static function getCourierCost($destination_id, $weight, $courierType = 'jne:jnt:lion'){

        $originType = 'subdistrict';
        $origin = self::$origin;//kode kecamatan mojoanyar
        $curl = curl_init();
        $api_key = self::$api_key;
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://pro.rajaongkir.com/api/cost",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "origin=$origin&originType=$originType&destination=$destination_id&destinationType=subdistrict&weight=$weight&courier=$courierType",
            CURLOPT_HTTPHEADER => array(
                "content-type: application/x-www-form-urlencoded",
                "key: $api_key"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return false;
        } else {
            return $response;
        }
    }

    public static function sumTotalWeight($items){

        foreach ($items as $item) {
            self::$totalWeight += ($item->quantity * $item->product->weight);
        }

        return self::$totalWeight;
    }

    public static function tracePackage($receipt_number, $courier){
        $api_key = self::$api_key;
        // return $courier;
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://pro.rajaongkir.com/api/waybill",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "waybill=$receipt_number&courier=$courier",
        CURLOPT_HTTPHEADER => array(
            "content-type: application/x-www-form-urlencoded",
            "key: $api_key"
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return false;
        } else {
            return $response;
        }
    }
}
