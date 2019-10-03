<?php

namespace App\Http\Controllers\PumController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ResponsibilityController extends Controller
{
    public function getAllData(Request $request){
        $emp_id     = $request->emp_id;
        $validator  = Validator::make($request->all(), [
            'emp_id'    => 'required | string',

        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>true, 'message' => "Required Parameters are Missing or Empty"], 401);
        }

        $temp = [];
        $getPum = DB::select("SELECT a.emp_id, a.pum_trx_id, a.trx_num, a.po_number, b.pum_trx_type_id, b.amount, b.resp_amount, b.description, '' as temp FROM `pum_trx_all` a LEFT JOIN `pum_trx_lines_all` b
                                        ON a.pum_trx_id = b.pum_trx_id
                                        WHERE a.emp_id = '$emp_id' AND a.pum_status = 'I'");

        foreach ($getPum as $data){
            $trxType    = DB::select("select po_number, trx_date FROM pum_trx_all where  emp_id = '$data->emp_id'");
            $data->temp = $trxType;
//            $temp[]   =  [$data];
        }
//        $getPum[0]->temp = "asdadsa";

//        $test = DB::select("SELECT trx_date, trx_num, '".$getPum."' as data FROM pum_trx_all where emp_id = '$emp_id'");

//        $temp = [$getP;

        return response()->json(['error'=>false, 'message' => $getPum], 200);
    }

    public function saveResponsibility(Request $request){
        $validator  = Validator::make($request->all(), [
            'emp_id'        => 'required | string',
            'pum_trx_id'    => 'required ',
            'trans_type'    => 'required ',
            'description'   => 'required |string',
            'store_code'    => 'string',
            'image'         => 'string',
            'kodeRespon'    => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>true, 'message' => "Required Parameters are Missing or Empty"], 401);
        }

    }




}
