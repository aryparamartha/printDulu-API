<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Validator;
use Carbon\Carbon;

class UserController extends Controller
{

    public $successStatus = 200;

    public function index(){
        return User::all();
    }

    public function create(request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'password' => 'required'
        ]);

        if($validator->fails()){
            return redirect('api/user')
                ->withErrors($validator)
                ->withInput();
        }

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = bcrypt($request->input('password'));
        $user->save();

        return "Data user berhasil disimpan";
    }

    public function update(request $request, $id){
        $name = $request->name;
        $email = $request->email;
        $phone = $request->phone;
        $password = $request->password;
        $username = $request->username;
        
        $user = User::find($id);
        $user->name = $name;
        $user->email = $email;
        $user->phone = $phone;
        $user->password = $password;
        $user->username = $username;
        $user->save();

        return "Data berhasil di update";
    }

    public function delete($id){
        $printer = Printer::find($id);
        $printer->delete();

        return "Data dihapus";
    }

    public function login(request $request){
        if(Auth::attempt(['email'=>request('email'), 'password' => request('password')])){
            $user = Auth::user();
            $token = $user->createToken('MyApp');
            $user->token = $token->accessToken;
            
            return response()->json($user, $this->successStatus);
        } else {
            return response()->json(['error'=>'Unathorized'], 401);
        }
    }
    
    public function logout(request $request){
        if(Auth::check()){
            Auth::user()->AauthAccessToken()->delete();
            return "Logout berhasil";
        }
    }

    public function profile(){
        $user = request()->user();

        return $user;
    }

}
