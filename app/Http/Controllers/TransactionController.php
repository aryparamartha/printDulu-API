<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Transaction;
use Validator;
use Carbon\carbon;
use App\User;

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
            // 'trans_file' => 'required',
            'file_link' => 'required',
            'id_status' => 'required',
            'file_desc' => 'required'
        ]);

        if($validator->fails()){
            return withErrors($validator);
        }
        $trans = new Transaction;
        $trans->id_user = $request->id_user;
        $trans->id_vendor = $request->id_vendor;
        $trans->trans_date = date("Y-m-d H:i:s");
        $trans->file_link = $request->file_link;
        $trans->file_desc = $request->file_desc;
        $trans->id_status = "0";
        $trans->save();

        $this->sendNotif($trans->id_vendor);

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
