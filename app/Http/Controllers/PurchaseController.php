<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Product;
use App\Models\User;
use App\Models\PurchaseDetail;
use App\Models\ShoppingCart;
use App\Services\CourierServices;
use App\Services\PurchaseServices;
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
    public function index($status = 'waiting')
    {
        $data = [
            'purchases' => Purchase::where('status', $status)->with(['purchase_details.product', 'user'])->get()
        ];
        return view('dashboard.pages.purchase', $data);
    }

    public function complete()
    {
        return $this->index('complete');
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
                $purchase->self_take = true;
                $purchase->total_cost = PurchaseServices::sumTotalCost($shoppingCart);
            }else{
                $purchase->self_take = false;
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
                ]);
                $PurchaseDetail->save();
                $item->delete();
            }

            DB::commit();

            return response()->json(['status' => 'success'], 200);
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
        //
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
        //
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


    public function getAvailableCourier(Purchase $purchase, $subdistrict_id)
    {
        $purchase_details = PurchaseDetail::where('purchase_id', $purchase->id)->with('product')->get();

        $weight = CourierServices::sumTotalWeight($purchase_details);
        $availableCourier = CourierServices::getCourierCost($subdistrict_id, $weight);
        return $availableCourier;
    }

    public function cetakResi(Purchase $purchase){
        $data = [
            'user' => User::find($purchase->user_id),
            'purchase' => $purchase
        ];
        return view('dashboard.print.resi', $data);
    }
}
