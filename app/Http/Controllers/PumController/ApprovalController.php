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

        $datas  = null;
        $query  = DB::select("SELECT a.pum_trx_id, a.emp_id, b.amount, a.pum_status
                                    FROM `pum_trx_all` a 
                                    LEFT JOIN `pum_trx_lines_all` b ON a.pum_trx_id = b.pum_trx_id 
                                    WHERE a.PUM_STATUS IN ('N','APP1','APP2','APP3','APP4') ");

        foreach ($query as $data){
            $columntemp   = 'approval_emp_id1';
            if($data->pum_status == 'N') {
                $columntemp = 'approval_emp_id1';
            } elseif ($data->pum_status == 'APP1'){
                $columntemp = 'approval_emp_id2';
            } elseif ($data->pum_status == 'APP2'){
                $columntemp = 'approval_emp_id3';
            } elseif ($data->pum_status == 'APP3'){
                $columntemp = 'approval_emp_id4';
            } elseif ($data->pum_status == 'APP4'){
                $columntemp = 'approval_emp_id5';
            }

            $findPumId   = DB::select("SELECT * FROM `pum_app_hierar` 
                                    WHERE emp_id = '$data->emp_id'
                                    and active_flag = 'Y'
                                    AND '$data->amount' BETWEEN proxy_amount_from AND proxy_amount_to
                                    AND  $columntemp = '$request->emp_id'"); /*33337 / 99231*/

            if ($findPumId != null) {
                $datas[] = $data->pum_trx_id;
            }
        }

        if ($datas == null) {
            return response()->json(['error' => true,'message' => 'No Data'],401);
        }

        foreach ($datas as $data){
            $result = DB::select("SELECT a.pum_trx_id, a.trx_num, b.name, a.trx_date, c.amount 
                                        FROM `pum_trx_all` a 
                                        LEFT JOIN `hr_employees` b on a.emp_id = b.emp_id 
                                        LEFT JOIN `pum_trx_lines_all` c on a.pum_trx_id = c.pum_trx_id 
                                        WHERE a.pum_trx_id= '$data'");

            $tempData[] = $result[0];
        }

        return response()->json(['error' => true,'message' => $tempData],200);
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
        $emp_id = $request->emp_id;
        $pum_id = $request->pum_trx_id;
        $pin    = $request->pin;
        $kode   = $request->kode;
        $reason = $request->reason_validate;

        $validator = Validator::make($request->all(), [
            'emp_id'            => 'required | string',
            'pum_trx_id'        => 'required | string',
            'pin'               => 'required | string',
            'kode'              => 'required | string',
            'reason_validate'   => 'string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>true, 'message' => "Required Parameters are Missing or Empty"], 401);
        }

        // Cek PIN user sebelum Approve PUM
        $nik    = DB::table('hr_employees')->select("emp_num")->where('emp_id', $emp_id)->get();
        $pinUser= DB::table('users')->select('pin')->where('emp_num',$nik[0]->emp_num)->get();
        $cekPin = password_verify($pin,$pinUser[0]->pin);
        if ($cekPin == false){
            return response()->json(['error'=>true, 'message' => "pin salah"], 400);
        }

        // Cek kode approval
        $query   = DB::select("SELECT a.pum_trx_id, a.emp_id, a.pum_status
                                     FROM `pum_trx_all` a 
                                     WHERE a.pum_trx_id = '$pum_id'");
        foreach ($query as $data) {
            $columntemp = 'approval_emp_id1';
            $columndate = 'approval_date1';
            if ($data->pum_status == 'N') {
                $columntemp = 'approval_emp_id1';
                $columndate = 'approval_date1';
                $status     = 'APP1';
                $nextApp    = "approval_emp_id2";
            } elseif ($data->pum_status == 'APP1') {
                $columntemp = 'approval_emp_id2';
                $columndate = 'approval_date2';
                $status     = 'APP2';
                $nextApp    = "approval_emp_id3";
            } elseif ($data->pum_status == 'APP2') {
                $columntemp = 'approval_emp_id3';
                $columndate = 'approval_date3';
                $status     = 'APP3';
                $nextApp    = "approval_emp_id4";
            } elseif ($data->pum_status == 'APP3') {
                $columntemp = 'approval_emp_id4';
                $columndate = 'approval_date4';
                $status     = 'APP4';
                $nextApp    = "approval_emp_id5";
            } elseif ($data->pum_status == 'APP4') {
                $columntemp = 'approval_emp_id5';
                $columndate = 'approval_date5';
                $status     = 'A';
                $nextApp    = "reason_validate"; // Pakai column reason_validate supya tidak error, karna reason_validate pasti kosong saati di approve sehingga status akan menjadi A
            }
        }

        // Cek Kode, apakah di Reject atau di Approve
        if($kode == 0) {
            DB::table('PUM_TRX_ALL')->where('PUM_TRX_ID', $pum_id)->update(['PUM_STATUS'=> 'R', $columntemp => $emp_id, $columndate=>$date, 'REASON_VALIDATE' => $reason]);
            return response()->json(['error'=>false, 'message' => 'REJECT SUKSES'], 200);
        } elseif ($kode == 1){
            // Cek apakah sudah final approve atau belum
            $cekFinal   = DB::select("SELECT a.$nextApp as approval
                                            FROM `pum_app_hierar` a 
                                            LEFT JOIN `pum_trx_all` b on a.emp_id = b.emp_id 
                                            LEFT JOIN `pum_trx_lines_all` c on b.pum_trx_id = c.pum_trx_id
                                            where b.pum_trx_id = 1961
                                            and a.active_flag = 'Y'
                                            and c.amount BETWEEN a.proxy_amount_from AND a.proxy_amount_to");

            $flag   = 0;
            foreach ($cekFinal as $data){
                if($data->approval > 1) {
                    $flag = $flag + 1;
                }
            }

            if ($flag == null){
                DB::table('PUM_TRX_ALL')->where('PUM_TRX_ID', $request->pum_trx_id)->update(['PUM_STATUS'=> 'A', $columntemp=> $emp_id, $columndate=>$date]);
            } else {
                DB::table('PUM_TRX_ALL')->where('PUM_TRX_ID', $request->pum_trx_id)->update(['PUM_STATUS'=> $status, $columntemp=> $emp_id, $columndate=>$date]);
            }
        } else {
            return response()->json(['error'=>true, 'message' => "ERROR"], 400);
        }
        return response()->json(['error'=>false, 'message' => 'APPROVAL SUKSES'], 200);
    }

}
