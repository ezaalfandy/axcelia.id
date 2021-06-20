<?php

namespace App\Http\Controllers;

use App\Models\Product;
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
            'shopping_carts' => ShoppingCart::with(['product', 'user'])->get()
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
                'product_id'=>'required',
                'quantity'=>'required',
            ]);

            $product = Product::findOrFail($request->get('product_id'));
            $product->stock -= $request->get('quantity');
            $product->save();

            $ShoppingCart = new ShoppingCart([
                'user_id' => Auth::user()->id,
                'product_id' => $request->get('product_id'),
                'quantity' => $request->get('quantity'),
                'description' => $request->get('description'),
            ]);

            $ShoppingCart->save();

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
        $product = Product::findOrFail($shoppingCart->product_id);
        $product->stock += $shoppingCart->quantity;
        $product->save();

        $shoppingCart->delete();
        DB::commit();

        return redirect()->back()
        ->with('success', 'data berhasil dihapus');
    }
}
