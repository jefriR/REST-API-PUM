<?php

namespace App\Http\Controllers\PumController;

use App\trx_all;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ResponsibilityController extends Controller
{
    public function getAllData(Request $request){
        $emp_id = $request->emp_id;
        $temp   = [];
        $validator  = Validator::make($request->all(), [
            'emp_id'    => 'required | string',

        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>true, 'message' => "Required Parameters are Missing or Empty"], 401);
        }


        $getPum = DB::select("SELECT a.emp_id, a.pum_trx_id, a.trx_num, a.po_number, b.pum_trx_type_id, b.amount, b.resp_amount, b.description, '' as trx_type FROM `pum_trx_all` a LEFT JOIN `pum_trx_lines_all` b
                                        ON a.pum_trx_id = b.pum_trx_id
                                        WHERE a.emp_id = '$emp_id' AND a.pum_status = 'I'");

        foreach ($getPum as $data){
            $trxType    = DB::select(" SELECT PUM_RESP_TRX_TYPE_ID, NAME, DESCRIPTION, CLEARING_ACCOUNT
                                                FROM `pum_resp_trx_types_all`
                                                WHERE PUM_TRX_TYPE_ID = '$data->pum_trx_type_id'");
            $data->trx_type = $trxType;
        }

        return response()->json(['error'=>false, 'message' => $getPum], 200);
    }

    public function submitResponsibility(Request $request){
        $validator  = Validator::make($request->all(), [
            'emp_id'        => 'required | string',
            'pum_trx_id'    => 'required ',
            'trans_type'    => 'required ',
            'description'   => 'required |string',
            'store_code'    => 'string',
            'image'         => 'string',
            'kode_respon'    => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>true, 'message' => "Required Parameters are Missing or Empty"], 401);
        }

        $getDataPum = DB::select("SELECT * FROM pum_trx_all WHERE pum_trx_id = '$request->pum_trx_id'");

//        $data  = new trx_all();
//        $data->
//        $data->save();

        return response()->json(['error'=>false, 'message' => $getDataPum[0]], 200);

    }




}






















