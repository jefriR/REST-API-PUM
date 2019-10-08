<?php

namespace App\Http\Controllers\PumController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DetailPumController extends Controller
{
    public function detailPum(Request $request){
        $validator = Validator::make($request->all(), [
            'pum_trx_id'      => 'required | string'
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>true, 'message' => "Required Parameters are Missing or Empty"], 401);
        }

        $getDataPum = DB::select("SELECT * FROM pum_trx_all a LEFT  JOIN pum_trx_lines_all b ON a.pum_trx_id = b.pum_trx_id WHERE a.pum_trx_id = '$request->pum_trx_id'");
        return response()->json(['error'=>false, 'message' => $getDataPum], 200);
    }

    public function summaryCreatePum(Request $request){
        $validator = Validator::make($request->all(), [
            'pum_trx_id'      => 'required | string'
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>true, 'message' => "Required Parameters are Missing or Empty"], 401);
        }

        $getDataPum = DB::select(" SELECT a.pum_trx_id, a.trx_num, a.trx_date,a.use_date, a.emp_id, a.resp_estimate_date, a.upload_data, b.pum_trx_type_id, b.description, b.amount, c.emp_num, c.name, d.description as department, '' as data_app
                                            FROM `pum_trx_all` a 
                                            LEFT JOIN `pum_trx_lines_all` b ON  a.pum_trx_id = b.pum_trx_id 
                                            LEFT JOIN `hr_employees` c ON a.emp_id = c.emp_id
                                            LEFT JOIN `hr_departments` d ON c.dept_id = d.dept_id
                                            /*LEFT JOIN `pum_resp_trx_types_all` e ON b.pum_trx_type_id = e.pum_trx_type_id*/ 
                                            WHERE a.pum_trx_id = '$request->pum_trx_id'");
        $getDataPum = $getDataPum[0];

        $getAppId   = DB::select(" SELECT *
                                            FROM `pum_app_hierar`
                                            WHERE EMP_ID = '$getDataPum->emp_id'
                                            AND '$getDataPum->amount' BETWEEN PROXY_AMOUNT_FROM AND PROXY_AMOUNT_TO
                                            AND ACTIVE_FLAG = 'Y'");



        $temp=[];
        foreach ($getAppId as $data){
//            $getNameApp1 = DB::select("SELECT EMP_ID, NAME FROM hr_employees WHERE emp_id = '$data->APPROVAL_EMP_ID1'");
//            $getNameApp2 = DB::select("SELECT EMP_ID, NAME FROM hr_employees WHERE emp_id = '$data->APPROVAL_EMP_ID2'");
//            $getNameApp3 = DB::select("SELECT EMP_ID, NAME FROM hr_employees WHERE emp_id = '$data->APPROVAL_EMP_ID3'");
//            $getNameApp4 = DB::select("SELECT EMP_ID, NAME FROM hr_employees WHERE emp_id = '$data->APPROVAL_EMP_ID4'");
//            $getNameApp5 = DB::select("SELECT EMP_ID, NAME FROM hr_employees WHERE emp_id = '$data->APPROVAL_EMP_ID5'");
//            $temp = ['App_1' => $getNameApp1, 'App_2' => $getNameApp2, 'App_3' => $getNameApp3, 'App_4' => $getNameApp4, 'App_5' => $getNameApp5];
        }

        $data1 = $getAppId[0];
        $data2 = $getAppId[1];
        $getNameApp1 = DB::select("SELECT EMP_ID, NAME FROM hr_employees WHERE emp_id = '$data->APPROVAL_EMP_ID1' OR emp_id = '$data2->APPROVAL_EMP_ID1'");
        $getNameApp2 = DB::select("SELECT EMP_ID, NAME FROM hr_employees WHERE emp_id = '$data->APPROVAL_EMP_ID2' OR emp_id = '$data2->APPROVAL_EMP_ID2'");
        $getNameApp3 = DB::select("SELECT EMP_ID, NAME FROM hr_employees WHERE emp_id = '$data->APPROVAL_EMP_ID3' OR emp_id = '$data2->APPROVAL_EMP_ID3'");
        $getNameApp4 = DB::select("SELECT EMP_ID, NAME FROM hr_employees WHERE emp_id = '$data->APPROVAL_EMP_ID4' OR emp_id = '$data2->APPROVAL_EMP_ID4'");
        $getNameApp5 = DB::select("SELECT EMP_ID, NAME FROM hr_employees WHERE emp_id = '$data->APPROVAL_EMP_ID5' OR emp_id = '$data2->APPROVAL_EMP_ID5'");
        $temp = ['App_1' => [$getNameApp1[0]], 'App_2' => $getNameApp2, 'App_3' => $getNameApp3, 'App_4' => $getNameApp4, 'App_5' => $getNameApp5];

        $getDataPum->data_app = $temp;


        return response()->json(['error'=>false, 'message' => $getDataPum], 200);

    }
}
