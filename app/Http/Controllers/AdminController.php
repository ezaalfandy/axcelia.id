<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\ShoppingCart;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Carbon;

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
            'total_user_waiting' => User::where('status', 'waiting')->count(),
            'active_product' => Product::where('status', 'available')->count(),
            'nonactive_product' => Product::where('status', 'unavailable')->count(),
            'preorder_product' => Product::where('status', 'preorder')->count(),
            'purchase_waiting_payment' => Purchase::where('status', 'waiting_payment')->count(),
            'purchase_waiting_confirmation' => Purchase::where('status', 'waiting_confirmation')->count(),
            'top_sales_this_month' => PurchaseDetail::whereMonth('created_at', Carbon::now()->month)
                                    ->selectRaw('purchase_details.*, SUM(quantity) as total')
                                    ->groupBy('product_varian_id')->with('productVarian.product')->orderBy('total', 'DESC')->get(),
            'income_this_month' => Purchase::whereMonth('created_at', Carbon::now()->month)->get()->sum('total_cost'),
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
