<?php

namespace App\Http\Controllers\PumController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class HistoryPumController extends Controller
{
    public function historyCreatePum(Request $request){
        $validator = Validator::make($request->all(), [
            'emp_id'    => 'required | string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>true, 'message' => "Required Parameters are Missing or Empty"], 401);
        }

        $data = DB::select("SELECT pum_trx_id, trx_num, trx_date, pum_status FROM `pum_trx_all` WHERE emp_id = '$request->emp_id'");
        return response()->json(['error'=>false, 'message' => $data], 200);
    }

    public function filterHistoryCreatePum(Request $request){
        $validator  = Validator::make($request->all(), [
            'emp_id'     => 'required | string',
            'status'     => 'required | string',
            'start_date' => 'required | date',
            'finish_date'=> 'required | date',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>true, 'message' => "Required Parameters are Missing or Empty"], 401);
        }

        $data   = DB::select("SELECT pum_trx_id, trx_num, trx_date, pum_status FROM `pum_trx_all`  WHERE emp_id = '$request->emp_id' AND PUM_STATUS LIKE '%$request->status%' AND TRX_DATE BETWEEN '$request->start_date' AND '$request->finish_date'");
        return response()->json(['error'=>false, 'message' => $data], 200);
    }




}
