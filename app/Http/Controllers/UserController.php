<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\Purchase;
use App\Models\ShoppingCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    private $api_key = "e7aba1c27611c9bc51b88b2f0c82246a";

    public function index($status = NULL){
        if($status == NULL)
        {
            $data = [
                "users" => user::all()
            ];
        }else
        {
            $data = [
                "users" => user::where(['status' => $status])->get()
            ];
        }
        return view('dashboard.pages.user', $data);
    }

    public function userApproved(){
        return $this->index('approved');
    }

    public function userWaiting(){
        return $this->index('waiting');
    }

    public function getToken(){
        $user = User::first();
        return $user->createToken('test');
    }

    public function getProvince(){
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://pro.rajaongkir.com/api/province",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: $this->api_key"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return false;
        } else {
            return $response;
        }
    }

    public function getCity($id_province)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://pro.rajaongkir.com/api/city?province=$id_province",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: $this->api_key"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return false;
        } else {
            return $response;
        }
    }

    public function getSubdistrict($id_city)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://pro.rajaongkir.com/api/subdistrict?city=$id_city",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "key: $this->api_key"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return false;
        } else {
            return $response;
        }
    }

    public function show(){

    }

    public function edit(User $user){
        $data = [
            'purchases' => Purchase::where('user_id', $user->id)->with(['purchase_details.product', 'user'])->get(),
            'shopping_carts' => ShoppingCart::where('user_id', $user->id)->with('product')->get(),
            'user' => $user
        ];
        return view('dashboard.pages.editUser', $data);
    }

    public function update(Request $request, User $user){

        $request->validate([
            'name'=>'required',
            'email'=>'required',
            'phone_number'=>'required',
            'status'=>'required',
        ]);
        $newData = array(
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'phone_number' => $request->get('phone_number'),
            'status' => $request->get('status'),
        );

        $user->update($newData);
        return redirect()->back()
        ->with('success', $request->get('status'));
    }


    public function changeStatus(User $user, Request $request)
    {
        $newData = array(
            'status' => $request->get('status')
        );
        $user->update($newData);
        return redirect()->back()
        ->with('success', 'status berhasil diubah');
    }
}
