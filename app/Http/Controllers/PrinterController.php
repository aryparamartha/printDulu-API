<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Printer;
use Validator;

class PrinterController extends Controller
{
    public function index(){
        return Printer::all();
    }

    public function create(request $request){
        $validator = Validator::make($request->all(), [
            'printer_name' => 'required',
            'printer_address' => 'required',
            'printer_email' => 'required|email',
            'printer_phone' => 'required'
        ]);

        if($validator->fails()){
            return redirect('api/printer')
                ->withErrors($validator)
                ->withInput();
        }

        $printer = new Printer;
        $printer->printer_name = $request->printer_name;
        $printer->printer_address = $request->printer_address;
        $printer->printer_phone = $request->printer_phone;
        $printer->printer_email = $request->printer_email;
        $printer->password = $request->password;
        $printer->save();

        return "Data Berhasil Disimpan";
    }

    public function update(request $request, $id){
        $printer_name = $request->printer_name;
        $printer_address = $request->printer_address;
        $printer_phone = $request->printer_phone;
        
        $printer = Printer::find($id);
        $printer->printer_name = $printer_name;
        $printer->printer_address = $printer_address;
        $printer->printer_phone = $printer_phone;
        $printer->save();

        return "Data berhasil di update";
    }

    public function delete($id){
        $printer = Printer::find($id);
        $printer->delete();

        return "Data dihapus";
    }
}
