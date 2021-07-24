<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\RedirectController;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect('/axcelia');
    }

    public function axcelia(){
        $data = array(
            'products' => Product::where(
                array(
                    'status' => 'available',
                    'brand' => 'axcelia'
                )
            )->get()
        );
        return view('dashboard.pages.product', $data);
    }

    public function mooncarla(){
        $data = array(
            'products' => Product::where(
                array(
                    'status' => 'available',
                    'brand' => 'mooncarla'
                )
            )->get()
        );
        return view('dashboard.pages.product', $data);
    }

    public function preOrder(){
        $data = array(
            'products' => Product::where(
                array(
                    'status' => 'preorder',
                )
            )->get()
        );
        return view('dashboard.pages.product', $data);
    }

    public function nonActive(){
        $data = array(
            'products' => Product::where(
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
        $name = $request->get('name');

        //CEK GAMBAR VALID
        if($request->image->isValid())
        {
            $image = $name.'.'.$request->image->extension();
            $request->file('image')->storeAs('product/', $image, 'public');
        }

        $request->validate([
            'name'=>'required',
            'price'=>'required',
            'stock'=>'required',
            'status'=>'sometimes',
            'brand'=>'sometimes',
            'image'=>'required',
            'weight'=>'required',
        ]);

        $Product = new Product([
            'name' => $name,
            'price' => $request->get('price'),
            'stock' => $request->get('stock'),
            'weight' => $request->get('weight'),
            'status' => $request->get('status'),
            'brand' => $request->get('brand'),
            'description' => $request->get('description'),
            'image' => $image
        ]);

        $Product->save();
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
        //
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
            'stock'=>'required',
            'image' => 'sometimes'
        ]);

        $name = $request->get('name');

        $newData = array(
            'id' => $request->get('id'),
            'name' => $name,
            'price' => $request->get('price'),
            'stock' => $request->get('stock'),
            'description' => $request->get('description'),
        );

        if($request->image !== NULL)
        {
            if($request->image->isValid())
            {
                //Delete OLD file
                Storage::disk('public')->delete('product/'.$product->image);

                $image = $name.'-'.time().'.'.$request->image->extension();
                $request->file('image')->storeAs('product/', $image, 'public');
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
