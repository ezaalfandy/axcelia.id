<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVarian;
use App\Models\ShoppingCart;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ShoppingCartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'shopping_carts' => ShoppingCart::with(['productVarian', 'user'])->get()
        ];
        return view('dashboard.pages.shoppingCart', $data);
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
                'product_varian_id'=>'required',
                'quantity'=>'required',
            ]);

            $productVarians = $request->get('product_varian_id');

            foreach ($productVarians as $key => $product_varian_id) {
                $quantity = $request->get('quantity')[$key];
                $productVarian = ProductVarian::findOrFail($product_varian_id);
                $productVarian->stock -= $quantity;
                $productVarian->save();

                $ShoppingCart = new ShoppingCart([
                    'user_id' => Auth::user()->id,
                    'product_varian_id' => $product_varian_id,
                    'quantity' => $quantity,
                    'description' => $request->get('description'),
                ]);
                $ShoppingCart->save();
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
     * @param  \App\Models\ShoppingCart  $shoppingCart
     * @return \Illuminate\Http\Response
     */
    public function show(ShoppingCart $shoppingCart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ShoppingCart  $shoppingCart
     * @return \Illuminate\Http\Response
     */
    public function edit(ShoppingCart $shoppingCart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ShoppingCart  $shoppingCart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShoppingCart $shoppingCart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ShoppingCart  $shoppingCart
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShoppingCart $shoppingCart)
    {
        DB::beginTransaction();
        $productVarian = ProductVarian::findOrFail($shoppingCart->product_varian_id);
        $productVarian->stock += $shoppingCart->quantity;
        $productVarian->save();

        $shoppingCart->delete();
        DB::commit();

        return redirect()->back()
        ->with('success', 'data berhasil dihapus');
    }
}
