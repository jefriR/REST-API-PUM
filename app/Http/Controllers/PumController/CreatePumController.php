<?php

namespace App\Http\Controllers\PumController;

use App\Department;
use App\Employees;
use App\trx_all;
use App\trx_lines_all;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CreatePumController extends Controller
{
    public $successStatus = 200;

    public function getdept(){
        $department = Department::all('dept_id', 'name', 'description');
        return response()->json(['error' => false,'department' => $department], $this->successStatus);
    }

    public function gettrxtype(){
        $trx        = DB::select("SELECT PUM_TRX_TYPE_ID,DESCRIPTION from pum_trx_types_all");
        return response()->json(['error' => false,'trx' => $trx], $this->successStatus);
    }

    public function getDocDetail(Request $request){
        $type       = $request->doc_type;
        $document   = DB::table('pum_ref_doc_all')->select('doc_num', 'doc_date', 'doc_amount')->where('doc_type', $type)->paginate(2);
        return response()->json(['error' => false,'document' => $document], $this->successStatus);
    }

    public  function createPum(Request $request){
        $validator = Validator::make($request->all(), [
            'emp_name'      => 'required | string',
            'emp_dept'      => 'required',
            'use_date'      => 'required | date',
            'resp_date'     => 'required | date',
            'doc_num'       => 'required',
            'trx_type'      => 'required',
            'description'   => 'required',
            'pin'           => 'required',
            'amount'        => 'required',
            'upload_file'   => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>true, 'message' => "Required Parameters are Missing or Empty"], 401);
        }

        // Cek PIN user sebelum create new PUM
        $nik    = DB::table('hr_employees')->select("emp_num")->where('name', $request->emp_name)->get();
        $pinUser= DB::table('users')->select('pin')->where('emp_num',$nik[0]->emp_num)->get();
        $cekPin = password_verify($request->pin,$pinUser[0]->pin);
        if ($cekPin == false){
            return response()->json(['error'=>true, 'message' => "pin salah"], 400);
        }

        //Get id Employ + Depart
        $emp_id = DB::table('hr_employees')->select('emp_id')->where('name',$request->emp_name)->get();
        $emp_id = $emp_id[0]->{'emp_id'};
        $dept_id = DB::table('hr_departments')->select('dept_id')->where('name',$request->emp_dept)->get();
        $dept_id = $dept_id[0]->{'dept_id'};

        //Get Trx_Num
        $getTrxNum  = DB::table('pum_trx_all')->select('trx_num')->orderBy('pum_trx_id')->get()->last();
        $getTrxNum  = $getTrxNum->{'trx_num'};
        $substring  = substr($getTrxNum,4);
        $thisYear   = date('Y');
        $trx_num    = $thisYear.($substring+1);

        $data  = new trx_all();
        $data->trx_num          = $trx_num;
        $data->trx_date         = date('Y-m-d');
        $data->emp_id           = $emp_id;
        $data->dept_id          = $dept_id;
        $data->po_number        = $request->doc_num;
        $data->use_date         = $request->use_date;
        $data->resp_estimate_date = $request-> resp_date;
        $data->pum_status       = 'N';
        $data->upload_data      = $request->upload_file;
        $data->save();

        $trx_id = DB::select("SELECT pum_trx_id FROM pum_trx_all WHERE PUM_TRX_ID = (SELECT MAX(PUM_TRX_ID) from pum_trx_all)");
        $trx_id = $trx_id[0]->{'pum_trx_id'};

        $data                   = new trx_lines_all();
        $data->pum_trx_id       = $trx_id;
        $data->pum_trx_type_id  = $request->trx_type;
        $data->description      = $request->description;
        $data->curr_code        = 'Rp';
        $data->amount           = $request->amount;
        $data->save();

//      app('app\Http\Controllers\PumContoller\CekApprovalController')->cekStatusPum($emp_id,$request->amount);

        $cekApproval    = DB::select("SELECT * FROM PUM_APP_HIERAR WHERE EMP_ID = '$emp_id' AND '$request->amount' BETWEEN PROXY_AMOUNT_FROM AND PROXY_AMOUNT_TO AND ACTIVE_FLAG = 'Y'");
        foreach ($cekApproval as $data){
            DB::select("INSERT INTO PUM_UPLOAD_TEMP(TRX_ID, APPROVAL_ID) VALUES ( '$trx_id', '$data->APPROVAL_EMP_ID1')");
        }

        return response()->json(['error' => false,'message' => 'sukses'], $this->successStatus);
    }
}
