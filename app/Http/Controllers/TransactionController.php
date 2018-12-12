<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Transaction;
use Validator;
use Carbon\carbon;

class TransactionController extends Controller
{
    public function show(request $request){
        //
    }

    public function create(request $request){
        $validator = Validator::make($request->all(), [
            'id_user' => 'required',
            'id_vendor' => 'required',
            // 'trans_date' => 'required',
            'trans_file' => 'required',
            'id_status' => 'required'
        ]);

        if($validator->fails()){
            return withErrors($validator);
        }
        
        if($request->hasFIle('trans_file')){
            $trans_file = $request->file('trans_file');
            $trans_file->move('public/berkas', $trans_file->getClientOriginalName());
            $file_name = $trans_file->getClientOriginalName();

            $trans = new Transaction;
            $trans->id_user = $request->id_user;
            $trans->id_vendor = $request->id_vendor;
            $trans->trans_date = date("Y-m-d H:i:s");
            $trans->trans_file = '/public/berkas/'.$file_name;
            $trans->id_status = "0";
            $trans->save();

            return response()->json([
                'success' => $trans,
                'message' => 'Data transaksi tersimpan'
            ]);
            
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data gagal disimpan'
            ]);
        }

    }

}
