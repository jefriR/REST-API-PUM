<?php

namespace App\Http\Controllers;

use App\Employees;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TestingController extends Controller
{
    public function testarray(Request $request){
        $validator = Validator::make($request->all(),[
            'data'     => 'required | array',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>true, 'message' => $validator->errors()], 401);
        }

        $datas  = $request->data;

//        foreach ($datas as $data){
//            echo  $data. ' ';
//        }

        return response()->json([], 200);
    }


    public function testing(Request $request){

$date = date('Y-m-d');
$dt2 = date('Y-m-d',mktime(0, 0, 0, date("m")-3, date("d"), date("Y")));

$select = DB::select("select * from pum_trx_all where trx_date between '$dt2' and '$date'");

dd($select);

echo $date."<br>".$dt2;
dd('s');

        $startdate = date('Y-m-d', Carbon::today());
        dd($startdate);

        $nik    = DB::table('hr_employees')->select("emp_num")->where('name', 'DENY ROHMANDA')->get();
        $pinUser= DB::table('users')->select('pin')->where('emp_num',$nik[0]->emp_num)->get(); dd($pinUser);
        $cekPin = password_verify($request->pin,$pinUser[0]->pin);
        if ($cekPin == false){
            return response()->json(['error'=>true, 'message' => "pin salah"], 400);
        }


        $test   = DB::select("SELECT a.APPROVAL_EMP_ID4 as approval
FROM `pum_app_hierar` a 
LEFT JOIN `pum_trx_all` b on a.emp_id = b.emp_id 
LEFT JOIN `pum_trx_lines_all` c on b.pum_trx_id = c.pum_trx_id
where b.pum_trx_id = 1961
and a.active_flag = 'Y'
and c.amount BETWEEN a.proxy_amount_from AND a.proxy_amount_to");


        dd('stop');




//        $nik    = DB::table('hr_employees')->select("emp_num")->where('name', 'SUGIANTO')->get();
//        $pinUser= DB::table('users')->select('pin')->where('emp_num',$nik[0]->emp_num)->get();


        DB::select("INSERT INTO PUM_UPLOAD_TEMP(TRX_ID, APPROVAL_ID) VALUES ( '1111', '1111')");
//        $cekApproval    =  \App\Http\Controllers\PumController\CekApprovalController::cekStatusPum(99216,1500000);
//        $cekApproval    =  app('App\Http\Controllers\PumContoller\CekApprovalController')->cekStatusPum(99216,1500000);
//            DB::select("SELECT * FROM PUM_APP_HIERAR WHERE EMP_ID = 99216 AND 1500000 BETWEEN PROXY_AMOUNT_FROM AND PROXY_AMOUNT_TO");

        $query   = DB::select("SELECT a.pum_trx_id, a.emp_id, b.amount, a.pum_status
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
                                    AND  $columntemp = 33337"); /*33337 / 99231*/

          if ($findPumId != null) {
              $datas[] = $data->pum_trx_id;
          }
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

//dd("st");

    }
}
