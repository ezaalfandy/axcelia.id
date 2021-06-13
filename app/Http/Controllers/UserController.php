<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
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

    public function getProvince($json = true){
        $data = Storage::get('location/indonesia.json');
		$array = json_decode($data, true);

		$returned = array();
		foreach ($array as $key => $value) {
			$returned[] = key($value);
		}
		sort($returned);
        if($json == true){
            return response()->json($returned, 200);
        }else{
            return $returned;
        }
    }

	public function getCity($province, $json = true){

        $data = Storage::get('location/indonesia.json');
		$array = json_decode($data, true);

		$returned = array();
		foreach ($array as $k => $v) {
			if(strcasecmp(key($v), $province) == 0){
				foreach ($array[$k] as $key => $value) {
					array_push($returned, $value);
				}
			}
		}
		sort($returned);
        if($json == true){
            return response()->json($returned[0], 200);
        }else{
            return $returned[0];
        }
	}

    public function show(){

    }

    public function edit(User $user){
        $data = [
            'purchases' => Purchase::where('user_id', $user->id)->with(['purchase_details.product', 'user'])->get(),
            'user' => $user,
            'provinces' => $this->getProvince(false),
            'cities' => $this->getCity($user->province, false),
        ];
        return view('dashboard.pages.editUser', $data);
    }

    public function update(Request $request, User $user){

        $request->validate([
            'name'=>'required',
            'email'=>'required',
            'phone_number'=>'required',
            'province'=>'required',
            'city'=>'required',
            'zip_code'=>'required',
            'address'=>'required',
            'status'=>'required',
        ]);
        $newData = array(
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'phone_number' => $request->get('phone_number'),
            'province' => $request->get('province'),
            'city' => $request->get('city'),
            'zip_code' => $request->get('zip_code'),
            'address' => $request->get('address'),
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
