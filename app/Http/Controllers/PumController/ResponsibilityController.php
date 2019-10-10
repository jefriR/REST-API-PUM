<?php

namespace App\Http\Controllers\PumController;

use App\resp_trx_all;
use App\resp_trx_lines_all;
use App\trx_all;
use Carbon\Carbon;
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
            'trx_type'      => 'required ',
            'amount'        => 'required',
            'description'   => 'required |string',
            'store_code'    => 'string',
            'image'         => 'string',
            'kode_respon'   => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>true, 'message' => "Required Parameters are Missing or Empty"], 401);
        }

        $getDataPum = DB::select("SELECT * FROM pum_trx_all WHERE pum_trx_id = '$request->pum_trx_id'");
        $getDataPum = $getDataPum[0];
        $trx_num    = $getDataPum->TRX_NUM;
        $trx_num    = $trx_num.'_1';
        $date       = date('Y-m-d', strtotime(Carbon::today()));

        $data                   = new resp_trx_all();
        $data->pum_resp_trx_num = $trx_num;
        $data->pum_trx_id       = $request->pum_trx_id;
        $data->resp_date        = $date;
        $data->resp_status      = 'N';
        $data->approval_emp_id1 = $getDataPum->APPROVAL_EMP_ID1;
        $data->approval_date1   = $getDataPum->APPROVAL_DATE1;
        $data->approval_emp_id2 = $getDataPum->APPROVAL_EMP_ID2;
        $data->approval_date2   = $getDataPum->APPROVAL_DATE2;
        $data->approval_emp_id3 = $getDataPum->APPROVAL_EMP_ID3;
        $data->approval_date3   = $getDataPum->APPROVAL_DATE3;
        $data->save();

        $resp_trx_id    = DB::select("SELECT a.pum_resp_trx_id as resp_trx_id
                                                FROM `pum_resp_trx_all` a 
                                                LEFT JOIN pum_trx_all b ON a.pum_trx_id = b.pum_trx_id
                                                WHERE PUM_RESP_TRX_ID = (SELECT MAX(PUM_RESP_TRX_ID) FROM pum_resp_trx_all)
                                                and b.EMP_ID = '$request->emp_id'");
        $resp_trx_id    = $resp_trx_id[0]->{'resp_trx_id'};

        $trx_line_id    = DB::select("SELECT PUM_TRX_LINE_ID FROM `pum_trx_lines_all` WHERE pum_trx_id = '$request->pum_trx_id'");
        $trx_line_id    = $trx_line_id[0]->{'PUM_TRX_LINE_ID'};

        $data                   = new resp_trx_lines_all();
        $data->pum_resp_trx_id  = $resp_trx_id;
        $data->pum_trx_line_id  = $trx_line_id;
        $data->line_num         = 1;
        $data->pum_resp_trx_type_id = $request->trx_type;
        $data->description      = $request->description;
        $data->amount           = $request->amount;
        $data->store_code       = $request->store_code;
        $data->save();

        $getAmountResp      = DB::select("SELECT resp_amount FROM pum_trx_lines_all WHERE pum_trx_id = '$request->pum_trx_id'");
        $getAmountResp      = $getAmountResp[0]->{'resp_amount'} + $request->amount;
        $getAmountRemaining = DB::select("SELECT amount from pum_trx_lines_all WHERE pum_trx_id = '$request->pum_trx_id'");
        $getAmountRemaining = $getAmountRemaining[0]->{'amount'} - $getAmountResp;

        $updateAmntReaming  =   DB::table('pum_trx_lines_all')->where('pum_trx_id', $request->pum_trx_id)->update(["RESP_AMOUNT"=>$getAmountResp, "AMOUNT_REMAINING" => $getAmountRemaining]);

        return response()->json(['error'=>false, 'message' => "sukses"], 200);

    }


//'pum_resp_trx_id','', '', 'resp_date', 'resp_status','approval_emp_id1', 'approval_date1','approval_emp_id2', 'approval_date2', 'approval_emp_id3', 'approval_date3',
//'pum_resp_trx_line_id','pum_resp_trx_id', '', 'line_num', 'pum_resp_trx_type_id','description', 'amount',


}






















