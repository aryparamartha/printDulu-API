<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Berkas;
use Validator;
use Carbon\Carbon;

class UploadController extends Controller
{
    public $successStatus = 200;

    public function index(){
        return Berkas::all();
    }

    public function addFile(Request $request){
        if($request->hasFile('berkas')){
            $fileBerkas=$request->file('berkas');
            $fileBerkas->move('public/berkas', $fileBerkas->getClientOriginalName());

            return $fileBerkas->getClientOriginalName();
            // $berkas = new Berkas();
            
            // $berkas->berkas = $request->berkas;

            // Storage::disk('public/berkas')->put($berkas, 'Berkas');
            // // return pathinfo(Storage::putFile('public/berkas', $request->file('berkas')->getClientOriginalName(), PATHINFO_FILENAME));

            // return 'File berhasil di taruh';
        } else {
            return 'NO file selected';
        }
    }
}
