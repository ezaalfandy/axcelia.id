<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Product;
use App\Models\User;
use App\Models\PurchaseDetail;
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

            $Purchase = new Purchase([
                'user_id' => Auth::user()->id,
            ]);
            $Purchase->save();

            $request->validate([
                'product_id'=>'required',
                'quantity'=>'required',
            ]);
            $PurchaseDetail = new PurchaseDetail([
                'purchase_id' => $Purchase->id,
                'product_id' => $request->get('product_id'),
                'quantity' => $request->get('quantity'),
            ]);
            $PurchaseDetail->save();

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
        $purchase->delete();
        return redirect()->back()
        ->with('success', 'data berhasil dihapus');
    }


    public function confirm(Purchase $purchase)
    {
        DB::beginTransaction();
        $purchase_details = PurchaseDetail::where('purchase_id', $purchase->id)->get();
        foreach ($purchase_details as $key => $value) {
            $product = Product::find($value->product_id);
            $product->stock -= $value->quantity;
            $product->save();
        }
        $purchase->status = 'complete';
        $purchase->save();
        DB::commit();

        return redirect()->back()
        ->with('success', 'penjualan berhasil');
    }

    public function cetakResi(Purchase $purchase){
        $data = [
            'user' => User::find($purchase->user_id)
        ];
        return view('dashboard.print.resi');
    }
}
