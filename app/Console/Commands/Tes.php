<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;

class Tes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /*$notificationBuilder = new PayloadNotificationBuilder('my title');
        $notificationBuilder->setBody('Hello world')
				            ->setSound('default');

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(['a_data' => 'my_data']);

        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        $token = "e6ApdFxomrI:APA91bEMLJgADKEqTBBSU5nB78-1Rrm8ZqQBn9N3RlKgidtbKtQwpbzMRPTtAQEyk_SjkBU4SFoEvyfNUmtYiMzfkvfmWcRLuLL13VbHNaczoX3sHTR8P1SSc4zikKlHty3MK7LTpxac";

        $downstreamResponse = FCM::sendTo($token, null, $notification, $data);*/

        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);

        $notificationBuilder = new PayloadNotificationBuilder('Aplikasi Sudah Di-install');
        $notificationBuilder->setBody('Selamat, aplikasi anda sudah berhasil di-install')
                            ->setSound('default');

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(['a_data' => 'my_data']);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        $token = "fB476af0oMs:APA91bGePS_AzH5fk7wfTEPEE3VPb9wh_wgFAUuNNjtNs32aV5byy_hG1-YLMZihbMp_yyTkrlt72wkoxaoUUrpuFMtFUoaHZdcvg-9reGeOCyR8zZ99wDaPH-OjrdB1slewE-WUSD_t";

        $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);

    }
}
