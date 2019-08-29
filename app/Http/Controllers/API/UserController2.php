<?php

namespace App\Http\Controllers\API;

use App\Department;
use App\Employees;
use App\User;
use App\trx_all;
use App\trx_lines_all;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController2 extends Controller
{
    public $successStatus = 200;

    public function login(Request $request){
        $validator = Validator::make($request->all(),[
            'emp_num'     => 'required',
            'password'  => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>true, 'message' => $validator->errors()], 401);
        }

        $nik         = $request->emp_num;
        $cekId       = DB::select("select * from users where emp_num like '$nik'");
        if($cekId == null){
            return response()->json(['error' => false,'message' => "User Not Exist"],302);
        }

        $cekPassword = password_verify($request->password,$cekId[0]->PASSWORD);

        if ($cekId > 0 && $cekPassword == true) {
            $user = Auth::user();
            $return = DB::table('hr_employees')->where('emp_num',$nik)->get();
//            dd($return);
            return response()->json(['error' => false,'message' => "Login Successfully", 'user' => $return[0]],200);
        } elseif($cekPassword == false){
            return response()->json(['error' => false,'message' => "Password Not Match"],302);
        }elseif ($cekId == null) {
            return response()->json(['error'=>'Unauthorised'],422);
        } else{
            return response()->json(['error' => true,'message' => "Something's Error"],422);
        }

//        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
//            // $user = Auth::user();
//            // $users   = DB::table('users')->leftJoin('hr_departments', 'users.dept_id', '=', 'hr_departments.dept_id')->where('users.user_id','=',$user->user_id)->get();
//            // $success['token'] =  $user->createToken('nApp')->accessToken;
//            // return response()->json(['success' => $users, $success], $this->successStatus);
//            return response()->json(['msg'=>"ping"]);
//        }
//        else{
//            return response()->json(['error'=>'Unauthorised'], 401);
//        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'emp_num' => 'required ',
            'password' => 'required | MIN : 6',
            'pin' => 'required | MIN : 6'
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>true, 'message' => "Required Parameters are Missing or Empty"], 401);
        }

        $emp_num    = $request->emp_num;
        $cekNik     = DB::select("select * from hr_employees where emp_num = '$emp_num'");


        if($cekNik != null) {
            $cekUserRegis = DB::select("select * from users where emp_num = '$emp_num'");
            if ($cekUserRegis == NULL) {
                $input              = $request->all();
                $input['password']  = bcrypt($input['password']);
                $user               = User::create($input);

                return response()->json(['error' => false,'message' => "User Created Successfully"], 201);
            } else {
                return response()->json(['error' => true, 'message' => "User Already Exists"], 422);
            }
        } else {
            return response()->json(['error'=> true, 'message' => "ID Dont Registered"], 422);
        }



//
        // $input              = $request->all();
        // $input['password']  = bcrypt($input['password']);
        // $user               = User::create($input);
//
//        $success['emp_id']  =  $user->name;
//        $success['dept_id'] =  $user->dept_id;
//
//        return response()->json(['success'=>$success], $this->successStatus);
    }

    public function details()
    {
        $depart = Department::all();
        $employ = Employees::all();
//        return response()->json(['Employee' => $employ], ['department' => $depart], $this->successStatus);
        return response()->json(['employee' => $employ, 'department' => $depart], $this->successStatus);
    }

    public function users(){
        $users  = User::all();

        return response()->json(['users'=>$users], $this->successStatus);
    }

    public function getAllDocument(){
        $documents = DB::table('pum_ref_doc_all')->get();
        return response()->json(['error' => false, 'documents' => $documents], $this->successStatus);
    }

    public function getdept(){
        $department = Department::all('dept_id', 'name', 'description');

        return response()->json(['error' => false,'department' => $department], $this->successStatus);
    }

    public function gettrxtype(){
        $trx        = DB::select("SELECT PUM_TRX_TYPE_ID,DESCRIPTION from pum_trx_types_all");

        return response()->json(['error' => false,'trx' => $trx], $this->successStatus);
    }

    public function typeDocument(Request $request){
        $type       = $request->doc_type;
        // $document   = DB::select("select doc_num, doc_date, doc_amount from pum_ref_doc_all where doc_type = '$type'");
        $document   = DB::table('pum_ref_doc_all')->select('doc_num', 'doc_date', 'doc_amount')->where('doc_type', $type)->paginate(2);

        return response()->json(['error' => false,'document' => $document], $this->successStatus);
    }

    public function createPum(Request $request){
        $validator = Validator::make($request->all(), [
            'emp_name'      => 'required | string',
            'emp_dept'      => 'required',
            'use_date'      => 'required | date',
            'resp_date'     => 'required | date',
            'doc_num'      => 'required',
            'trx_type'      => 'required',
            'description'   => 'required',
            'currency'      => 'required',
            'amount'        => 'required',
            'upload_file'   => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>true, 'message' => "Required Parameters are Missing or Empty"], 401);
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
        $data->trx_num      = $trx_num;
        $data->trx_date     = date('Y-m-d');
        $data->emp_id       = $emp_id;
        $data->dept_id      = $dept_id;
        $data->po_number    = $request->doc_num;
        $data->use_date      = $request->use_date;
        $data->resp_estimate_date = $request-> resp_date;
        $data->upload_data  = $request->upload_file;
        $data->save();

        $trx_id = DB::select("SELECT pum_trx_id FROM pum_trx_all WHERE PUM_TRX_ID = (SELECT MAX(PUM_TRX_ID) from pum_trx_all)");
        $trx_id = $trx_id[0]->{'pum_trx_id'};

        $data   = new trx_lines_all();

        $data->pum_trx_id       = $trx_id;
        $data->pum_trx_type_id  = $request->trx_type;
        $data->description      = $request->description;
        $data->curr_code        = $request->currency;
        $data->amount           = $request->amount;
        $data->save();


        return response()->json(['error' => false,'message' => 'sukses'], $this->successStatus);
    }

    public function testing(){
        $getTrxNum  = DB::table('pum_trx_all')->select('trx_num')->orderBy('pum_trx_id')->get()->last();
        $getTrxNum  = $getTrxNum->{'trx_num'};
        $substring  = substr($getTrxNum,4);
        $thisYear   = date('Y');
        $trx_num    = $thisYear.($substring+1);

        dd($substring);

        return response()->json(['error' => false,'message' => $getTrxNum], $this->successStatus);

    }


}
