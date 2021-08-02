<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVarian;
use App\Events\StockUpdate;
use App\Models\InboundStock;
use App\Models\PurchaseDetail;
use Illuminate\Http\Request;
use Illuminate\Routing\RedirectController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect('/product-ready');
    }

    public function productReady(){
        $data = array(
            'products' => Product::with('productVarian')->where(
                array(
                    'status' => 'available',
                    'brand' => 'product-ready'
                )
            )->get()
        );
        return view('dashboard.pages.product', $data);
    }

    public function barangUnik(){
        $data = array(
            'products' => Product::with('productVarian')->where(
                array(
                    'status' => 'available',
                    'brand' => 'barang-unik'
                )
            )->get()
        );
        return view('dashboard.pages.product', $data);
    }

    public function preOrder(){
        $data = array(
            'products' => Product::with('productVarian')->where(
                array(
                    'status' => 'preorder',
                )
            )->get()
        );
        return view('dashboard.pages.product', $data);
    }

    public function nonActive(){
        $data = array(
            'products' => Product::with('productVarian')->where(
                array(
                    'status' => 'unavailable',
                )
            )->get()
        );
        return view('dashboard.pages.product', $data);
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
            'name'=>'required',
            'price'=>'required|numeric',
            'status'=>'sometimes',
            'brand'=>'sometimes',
            'image'=>'required',
            'weight'=>'required|numeric',
            'product_varian_name'=>'required',
            'product_varian_stock'=>'required',
        ]);

        $name = $request->get('name');

        //CEK GAMBAR VALID
        if($request->image->isValid())
        {
            $image = $name.'.'.$request->image->extension();
            $request->file('image')->storeAs('products/', $image, 'public');
        }

        DB::beginTransaction();
        $Product = new Product([
            'name' => $name,
            'price' => $request->get('price'),
            'weight' => $request->get('weight'),
            'status' => $request->get('status'),
            'brand' => $request->get('brand'),
            'description' => $request->get('description'),
            'image' => $image
        ]);

        $Product->save();

        foreach ($request->get('product_varian_name') as $k => $v) {
            $productVarian = new ProductVarian([
                'product_id' => $Product->id,
                'name' => $v,
                'stock' => $request->get('product_varian_stock')[$k]
            ]);
            $productVarian->save();
        }
        DB::commit();
        return redirect()->back()
        ->with('success', 'Product created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return response()->json($product, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $data = array(
            'product' => $product,
            'product_varians' => ProductVarian::where('product_id', $product->id)->get(),
            'inbound_stocks' => InboundStock::select('inbound_stocks.*')->join('product_varians', 'product_varians.id', 'inbound_stocks.product_varian_id')
                                ->where('product_id', $product->id)->get(),
            'purchase_details' => PurchaseDetail::whereIn('product_varian_id', ProductVarian::where('product_id', $product->id)->get()->pluck('id'))
                                ->with(['productVarian', 'purchase.user'])->get()
        );
        // dd($data['purchase_details']);
        return view('dashboard.pages.product-detail', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'id'=>'required',
            'name'=>'required',
            'price'=>'required',
            'image' => 'sometimes'
        ]);

        $name = $request->get('name');

        $newData = array(
            'id' => $request->get('id'),
            'name' => $name,
            'price' => $request->get('price'),
            'description' => $request->get('description'),
        );

        if($request->image !== NULL)
        {
            if($request->image->isValid())
            {
                //Delete OLD file
                Storage::disk('public')->delete('products/'.$product->image);

                $image = $name.'-'.time().'.'.$request->image->extension();
                $request->file('image')->storeAs('products/', $image, 'public');
                $newData['image'] = $image;
            }
        }

        $product->update($newData);
        return redirect()->back()
        ->with('success', 'products berhasil diupdate');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        Storage::disk('public')->delete('product/'.$product->image);
        $product->delete();
        return redirect()->back()
        ->with('success', 'product berhasil dihapus');
    }


    public function changeStatus(Product $product, Request $request)
    {
        $newData = array(
            'status' => $request->get('status')
        );
        $product->update($newData);
        return redirect()->back()
        ->with('success', 'status berhasil diubah');
    }
}
