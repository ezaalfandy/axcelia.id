<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\ShoppingCart;
use App\Models\User;
use App\Models\Admin;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'total_user_approved' => User::where('status', 'approved')->count(),
            'active_product' => Product::where('status', 'available')->count(),
            'purchase_waiting_payment' => Purchase::where('status', 'waiting_payment')->count(),
            'purchase_waiting_confirmation' => Purchase::where('status', 'waiting_confirmation')->count(),
            'current_sale' => Product::where('status', 'available')->addSelect(['shopping_cart' => ShoppingCart::selectRaw('sum(quantity) as total')
                ->whereColumn('product_id', 'products.id')
                ->groupBy('product_id')
            ])->addSelect(['purchases_detail' => PurchaseDetail::selectRaw('sum(quantity) as total')
                ->whereColumn('product_id', 'products.id')
                ->join('purchases', 'purchase_id', 'purchases.id')
                ->where('purchases.status',  '!=', 'complete')
                ->groupBy('product_id')
            ])->limit(5)->get()
        ];
        return view('dashboard.pages.dashboard', $data);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        return view('dashboard.pages.profile', ['admin' => $admin]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required',
            'password'=>'sometimes|confirmed',
        ]);

        $admin->name = $request->get('name');
        $admin->email =  $request->get('email'); 

        if($request->password !== NULL)
        {
            $admin->password = $request->password;
        }

        $admin->save();

        return redirect()->back()
        ->with('success', 'admin berhasil diupdate');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        //
    }
}
