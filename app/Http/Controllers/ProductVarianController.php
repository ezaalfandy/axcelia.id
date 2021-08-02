<?php

namespace App\Http\Controllers;

use App\Models\ProductVarian;
use Illuminate\Http\Request;

class ProductVarianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $request->validate([
            'product_id'=>'required',
            'name'=>'required',
            'stock'=>'required',
        ]);
        $ProductVarian = new ProductVarian([
            'product_id' => $request->get('product_id'),
            'name' => $request->get('name'),
            'stock' => $request->get('stock'),
        ]);
        $ProductVarian->save();

        return redirect()->back()
        ->with('success', 'Product_varian created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductVarian  $productVarian
     * @return \Illuminate\Http\Response
     */
    public function show(ProductVarian $productVarian)
    {
        return response()->json($productVarian, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductVarian  $productVarian
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductVarian $productVarian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductVarian  $productVarian
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductVarian $productVarian)
    {
        $request->validate([
            'name'=>'required',
            'stock'=>'required',
        ]);
        $newData = array(
            'name' => $request->get('name'),
            'stock' => $request->get('stock'),
        );

        $productVarian->update($newData);
        return redirect()->back()
        ->with('success', 'product_varians berhasil diupdate');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductVarian  $productVarian
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductVarian $productVarian)
    {
        //
    }
}
