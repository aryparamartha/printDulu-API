<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Transaction;
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
        if ($request->hasFile('profile_pic')){
            $profile_pic = $request->file('profile_pic');
            $profile_pic->move('public/berkas', $profile_pic->getClientOriginalName());
            $pic_name = $profile_pic->getCLientOriginalName();
        } else {
            $pic_name = 'trihard.jpg';
        }
        
        $user = User::find($id);
        $user->name = $name;
        $user->email = $email;
        $user->phone = $phone;
        $user->password = $password;
        $user->username = $username;
        $user->profile_pic = '/public/berkas/'.$pic_name;
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

    public function showVendor(){
        $vendor = User::where('admin_status',1)->get();

        return $vendor;
    }

    public function showTransaction(){
        $user = request()->user();

        $trans = Transaction::select('trans_det.*', 'transactions.trans_total','transactions.trans_file', 'transactions.id_user')
            ->join('trans_det', 'transactions.id','=','trans_det.id_trans')
            ->join('users','users.id','=','transactions.id_user')
            ->where('users.id',$user['id'])
            ->get();
            return $trans;
    }

    public function showTransactionVendor(){
        $user = request()->user();
        $trans = Transaction::select('trans_det.*', 'transactions.trans_total','transactions.trans_file', 'transactions.id_user')
            ->join('trans_det', 'transactions.id','=','trans_det.id_trans')
            ->join('users','users.id','=','transactions.id_user')
            ->where('transactions.id_vendor',$user['id'])
            ->get();
            return $trans;
    }
}
