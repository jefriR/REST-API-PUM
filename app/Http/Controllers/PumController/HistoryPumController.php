<?php

namespace App\Http\Controllers\PumController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class HistoryPumController extends Controller
{
    public function historyCreatePum(Request $request){
        $validator = Validator::make($request->all(), [
            'emp_id'      => 'required | string'
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>true, 'message' => "Required Parameters are Missing or Empty"], 401);
        }

        $data = DB::select("SELECT a.trx_id,b.trx_num, d.name,c.amount FROM `pum_upload_temp` a LEFT JOIN `pum_trx_all` b ON a.trx_id = b.pum_trx_id LEFT JOIN `pum_trx_lines_all` c ON a.trx_id = c.pum_trx_id LEFT JOIN `hr_employees` d ON b.emp_id = d.emp_id WHERE a.APPROVAL_ID = '$request->emp_id'");
    }

}
