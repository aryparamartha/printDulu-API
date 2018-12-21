<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Transaction;
use Validator;
use Carbon\carbon;
use App\User;
use App\TransDet;
use FCM;
use App\Console\Commands\Tes;

class TransactionController extends Controller
{

    public $successStatus = 200;

    public function show(request $request){
        //
    }

    public function create(request $request){
        $validator = Validator::make($request->all(), [
            'id_user' => 'required',
            'id_vendor' => 'required',
            'nama_file' => 'required',
            'file_location' => 'required',
            // 'id_status' => 'required',
            'format_file' => 'required'
        ]);

        if($validator->fails()){
            return withErrors($validator);
        }
        $trans = new Transaction;
        $trans->id_user = $request->id_user;
        $trans->id_vendor = $request->id_vendor;
        $trans->trans_date = date("Y-m-d H:i:s");
        $trans->id_status = "0";
        $trans->save();

        $det = new TransDet;
        $det->id_trans = $trans->id;
        $det->nama_file = $request->nama_file;
        $det->format_file = $request->request_file;
        $det->file_location = $request->file_location;
        $det->save();

        $this->sendNotif($trans->id_vendor);

        return response()->json($trans, $det, $this->successStatus);

    }

    public function editTrans(request $request, $id){

            //'id_user' => 'required',
            //'id_vendor' => 'required',
            //'nama_file' => 'required',
            //'file_location' => 'required',
            // 'id_status' => 'required',
            //'format_file' => 'required'

        $nama_file = $request->nama_file;
        $file_location = $request->file_location;
        $format_file = $request->format_file;
        $trans_total = $request->trans_total;
        $id_status = $request->id_status;

        $trans = Transaction::find($id);
        $trans->trans_total = $trans_total;
        $trans->id_status = $id_status;

        $trans->save();

        TransDet::where('id_trans', $trans->id)
        ->update([
            'nama_file' => $nama_file,
            'format_file' => $format_file,
            'file_location' => $file_location
        ]);

        return response()->json($trans, $this->successStatus);
    }
    
    public function sendNotif($id)
    {

        $user = User::find($id);

        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);

        $notificationBuilder = new PayloadNotificationBuilder('Pesanan Baru!');
        $notificationBuilder->setBody('Anda mendapatkan satu pesanan baru!')
                            ->setSound('default');

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(['a_data' => 'my_data']);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        /*$token = "fB476af0oMs:APA91bGePS_AzH5fk7wfTEPEE3VPb9wh_wgFAUuNNjtNs32aV5byy_hG1-YLMZihbMp_yyTkrlt72wkoxaoUUrpuFMtFUoaHZdcvg-9reGeOCyR8zZ99wDaPH-OjrdB1slewE-WUSD_t";*/

        $downstreamResponse = FCM::sendTo($user->fcm_token, $option, $notification, $data);
    }


}
