<?php

namespace App\Http\Controllers\PumController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ApprovalController extends Controller
{
    public function listApproval(Request $request){
        $validator = Validator::make($request->all(), [
            'emp_id'      => 'required | string'
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>true, 'message' => "Required Parameters are Missing or Empty"], 401);
        }

        $data = DB::select("SELECT a.trx_id,b.trx_num, d.name,c.amount FROM `pum_upload_temp` a LEFT JOIN `pum_trx_all` b ON a.trx_id = b.pum_trx_id LEFT JOIN `pum_trx_lines_all` c ON a.trx_id = c.pum_trx_id LEFT JOIN `hr_employees` d ON b.emp_id = d.emp_id WHERE a.APPROVAL_ID = '$request->emp_id'");
        return response()->json(['error'=>false, 'message' => $data], 200);
    }

    public function detailPum(Request $request){
        $validator = Validator::make($request->all(), [
            'pum_trx_id'      => 'required | string'
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>true, 'message' => "Required Parameters are Missing or Empty"], 401);
        }

        $data = DB::select(" SELECT a.pum_trx_id, a.trx_num, a.trx_date,a.use_date, a.resp_estimate_date, a.upload_data, b.description, b.amount, c.emp_num, c.name, d.description as department
                                    FROM `pum_trx_all` a 
                                    LEFT JOIN `pum_trx_lines_all` b ON  a.pum_trx_id = b.pum_trx_id 
                                    LEFT JOIN `hr_employees` c ON a.emp_id = c.emp_id
                                    LEFT JOIN `hr_departments` d ON c.dept_id = d.dept_id
                                    WHERE a.pum_trx_id = '$request->pum_trx_id'");

        return response()->json(['error'=>false, 'message' => $data], 200);

    }

    public function approvePum(Request $request){
        $date   = date('Y-m-d');
        $validator = Validator::make($request->all(), [
            'emp_id'        => 'required | string',
            'pum_trx_id'    => 'required | string',
            'kode_id'       => 'required | number',
            'description'   => 'string',
            'pin'           => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>true, 'message' => "Required Parameters are Missing or Empty"], 401);
        }

        DB::table('PUM_TRX_ALL')->where('PUM_TRX_ID', $request->pum_trx_id)->update(['PUM_STATUS'=> 'APP1', 'APPROVAL_EMP_ID1'=> $request->emp_id, 'APPROVAL_DATE1'=>$date]);
        DB::table('PUM_UPLOAD_TEMP')->where('TRX_ID', $request->pum_trx_id)->delete();

        return response()->json(['error'=>false, 'message' => 'APPROVAL 1 SUKSES'], 200);


    }
}
