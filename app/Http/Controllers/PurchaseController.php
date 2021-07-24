<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Product;
use App\Models\User;
use App\Models\PurchaseDetail;
use App\Models\ShoppingCart;
use App\Services\CourierServices;
use App\Services\PurchaseServices;
use App\Services\DiscountServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'purchases' => Purchase::where('status', '!=', 'complete')->with(['purchase_details.product', 'user'])->get()
        ];
        return view('dashboard.pages.purchase', $data);
    }

    public function complete()
    {
        $data = [
            'purchases' => Purchase::where('status', 'complete')->with(['purchase_details.product', 'user'])->get()
        ];
        return view('dashboard.pages.purchase', $data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->status == 'approved')
        {
            DB::beginTransaction();

            $request->validate([
                'shopping_cart_id'=>'required',
                'self_take'=>'sometimes',
                'province'=>'sometimes',
                'city'=>'sometimes',
                'subdistrict'=>'sometimes',
                'address'=>'sometimes',
                'courier'=>'sometimes',
                'courier_cost'=>'sometimes',
            ]);

            $purchase = new Purchase([
                'user_id' => Auth::user()->id,
            ]);

            $shoppingCart = ShoppingCart::whereIn('id', $request->get('shopping_cart_id'))->with('product')->get();
            if($request->has('self_take')){
                $purchase->payment_receipt = time();
                $purchase->self_take = true;
                $purchase->total_cost = PurchaseServices::sumTotalCost($shoppingCart);
            }else{
                $purchase->self_take = false;
                $purchase->payment_receipt = time();
                $purchase->province = $request->get('province');
                $purchase->city = $request->get('city');
                $purchase->subdistrict = $request->get('subdistrict');
                $purchase->address = $request->get('address');
                $purchase->courier = $request->get('courier');
                $purchase->courier_cost = $request->get('courier_cost');
                $purchase->total_cost = PurchaseServices::sumTotalCost($shoppingCart, $request->get('courier_cost'));
            }

            $totalWeight = CourierServices::sumTotalWeight($shoppingCart);
            $purchase->total_weight = $totalWeight;
            $purchase->save();

            foreach ($request->get('shopping_cart_id') as $k => $v) {
                $item = ShoppingCart::findOrFail($v);
                $PurchaseDetail = new PurchaseDetail([
                    'purchase_id' => $purchase->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'description' => $item->description,
                ]);
                $PurchaseDetail->save();
                $item->delete();
            }

            DB::commit();

            return response()->json(['status' => 'success', 'purchase_id' => $purchase->id], 200);
        }else
        {
            return response()->json(['status' => 'failed'], 401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function show(Purchase $purchase)
    {
        $purchase_details = PurchaseDetail::where('purchase_id', $purchase->id)->with(
        ['product' =>
            function($query){
                $query->orderBy('name', 'ASC');
            }
        ])->get();
        return response()->json($purchase_details, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function edit(Purchase $purchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Purchase $purchase)
    {
        if(Auth::user()->status == 'approved')
        {
            $request->validate([
                'self_take'=>'sometimes',
                'province'=>'sometimes',
                'city'=>'sometimes',
                'subdistrict'=>'sometimes',
                'address'=>'sometimes',
                'courier'=>'sometimes',
                'courier_cost'=>'sometimes',
            ]);

            $shoppingCart = purchaseDetail::where('purchase_id', $purchase->id)->with('product')->get();
            if($request->has('self_take')){
                $purchase->payment_receipt = time();
                $purchase->self_take = true;
                $purchase->total_cost = PurchaseServices::sumTotalCost($shoppingCart);
            }else{
                $purchase->self_take = false;
                $purchase->payment_receipt = time();
                $purchase->province = $request->get('province');
                $purchase->city = $request->get('city');
                $purchase->subdistrict = $request->get('subdistrict');
                $purchase->address = $request->get('address');
                $purchase->courier = $request->get('courier');
                $purchase->courier_cost = $request->get('courier_cost');PurchaseServices::sumTotalCost($shoppingCart);
            }

            $purchase->save();


            return response()->json(['status' => 'success'], 200);
        }else
        {
            return response()->json(['status' => 'failed'], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Purchase $purchase)
    {
        DB::beginTransaction();
        $purchase_details = PurchaseDetail::where('purchase_id', $purchase->id)->get();
        foreach ($purchase_details as $key => $value) {
            $product = Product::find($value->product_id);
            $product->stock += $value->quantity;
            $product->save();
        }

        $purchase->delete();

        DB::commit();
        return redirect()->back()
        ->with('success', 'data berhasil dihapus');
    }


    public function confirm(Purchase $purchase)
    {
        $purchase->status = 'complete';
        $purchase->save();
        return redirect()->back()
        ->with('success', 'penjualan berhasil');
    }

    public function updateDiscount(Purchase $purchase, Request $request){

        $purchase_details = PurchaseDetail::where('purchase_id', $purchase->id)->with(
            ['product' =>
                function($query){
                    $query->orderBy('name', 'ASC');
                }
        ])->get();

        $discount = $request->get('discount');

        DB::beginTransaction();
        foreach ($purchase_details as $key => $value) {
            $value->discount = $discount[$key];
            $value->update();
        }

        DiscountServices::calculateTotalCost($purchase);

        if($request->get('confirm') == 1)
        {
            $purchase->status = 'complete';
            $purchase->save();
        }

        DB::commit();

        return redirect()->back()
        ->with('success', 'Update diskon berhasil');
    }


    public function updateResi(Purchase $purchase, Request $request){
        $request->validate([
            'receipt_number'=>'required',
        ]);

        $purchase->receipt_number = $request->get('receipt_number');
        $purchase->save();

        return redirect()->back()
        ->with('success', 'Update diskon berhasil');
    }

    public function getAvailableCourier(Purchase $purchase, $subdistrict_id)
    {
        $purchase_details = PurchaseDetail::where('purchase_id', $purchase->id)->with('product')->get();

        $weight = CourierServices::sumTotalWeight($purchase_details);
        $availableCourier = CourierServices::getCourierCost($subdistrict_id, $weight);
        return $availableCourier;
    }

    public function tracePackage(Purchase $purchase)
    {
        $receipt_number = $purchase->receipt_number;
        $courier = strtolower(explode(' ', $purchase->courier)[0]);
        $trace = CourierServices::tracePackage($receipt_number, $courier);
        return $trace;
    }

    public function estimateCourier($subdistrict_id)
    {
        $availableCourier = CourierServices::getCourierCost($subdistrict_id, 100);
        return $availableCourier;
    }

    public function cetakResi(Purchase $purchase){
        $data = [
            'user' => User::find($purchase->user_id),
            'purchase' => $purchase
        ];
        return view('dashboard.print.resi', $data);
    }

    public function cetakNota(Purchase $purchase){
        $data = [
            'user' => User::find($purchase->user_id),
            'purchase' => $purchase,
            'purchase_details' => PurchaseDetail::where('purchase_id', $purchase->id)->with('product')->get()
        ];
        return view('dashboard.print.notaDotMatrix', $data);
    }
}
