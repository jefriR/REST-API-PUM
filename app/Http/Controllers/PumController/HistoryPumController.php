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

        $data = DB::select("SELECT pum_trx_id, trx_num, trx_date, pum_status FROM `pum_trx_all` WHERE emp_id = '$request->emp_id' ORDER BY trx_date DESC ");
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

        $data   = DB::select("SELECT pum_trx_id, trx_num, trx_date, pum_status FROM `pum_trx_all`  WHERE emp_id = '$request->emp_id' AND PUM_STATUS LIKE '%$request->status%' AND USE_DATE BETWEEN '$request->start_date' AND '$request->finish_date'");
        return response()->json(['error'=>false, 'message' => $data], 200);
    }

    public function historyApprovalPum(Request $request){
        $status = 'APP';
        $start_date = date('Y-m-d',mktime(0, 0, 0, date("m")-3, date("d"), date("Y")));
        $end_date   = date('Y-m-d');

        $validator = Validator::make($request->all(), [
            'emp_id'        => 'required | string',
            'status'        => 'string',
            'start_date'    => 'date',
            'end_date'      => 'date',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>true, 'message' => "Required Parameters are Missing or Empty"], 401);
        }

        if ($request->status != null) {
            $status     = $request->status;
            $start_date = $request->start_date;
            $end_date   = $request->end_date;
        }

        $data = DB::select("SELECT a.created_at as actiondate, b.pum_trx_id, b.trx_num, b.trx_date ,c.name as fullname, e.description as department, d.*
                                    FROM 
                                        (SELECT pum_trx_id, created_at FROM `approval_pums` 
                                            WHERE emp_id = '$request->emp_id' 
                                            AND status = '$status'
                                            AND created_at BETWEEN '$start_date' AND '$end_date') a,
                                        `pum_trx_all` b
                                        LEFT JOIN `hr_employees` c ON b.emp_id = c.emp_id
                                        LEFT JOIN `pum_trx_lines_all` d  ON b.pum_trx_id = d.pum_trx_id
                                        LEFT JOIN `hr_departments` e ON b.dept_id = e.dept_id
                                    WHERE a.pum_trx_id = b.pum_trx_id
                                    ORDER BY actiondate DESC ");

        return response()->json(['error'=>false, 'message' => $data], 200);
    }



}
