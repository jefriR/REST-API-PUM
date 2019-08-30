<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    use AuthenticatesUsers;

    public function username()
    {
        return 'emp_num';
    }

    public function login(Request $request){
        $validator = Validator::make($request->all(),[
            'emp_num'     => 'required | numeric',
            'password'    => 'required | string'
        ]);

        $nik         = $request->emp_num;
        $cekId       = DB::select("select * from users where emp_num like '$nik'");
        if($cekId == null){
            return response()->json(['error' => false,'message' => "User Not Exist"],302);
        }

        if ($validator->fails()) {
            return response()->json(['error'=>true, 'message' => $validator->errors()], 401);
        }

        $cekPassword = password_verify($request->password,$cekId[0]->PASSWORD);

        if ($cekId > 0 && $cekPassword == true) {
            $return = DB::select("SELECT a.*, b.PIN FROM hr_employees a, users b where a.EMP_NUM = '$nik' and b.emp_num = a.emp_num");
            return response()->json(['error' => false,'message' => "Login Successfully", 'user' => $return[0]],200);
        } elseif($cekPassword == false){
            return response()->json(['error' => false,'message' => "Password Not Match"],302);
        }elseif ($cekId == null) {
            return response()->json(['error'=>'Unauthorised'],422);
        } else{
            return response()->json(['error' => true,'message' => "Something's Error"],422);
        }
    }

    public function register(Request $request){
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
                $input['pin']       = bcrypt($input['pin']);
                $user               = User::create($input);

                return response()->json(['error' => false,'message' => "User Created Successfully"], 201);
            } else {
                return response()->json(['error' => true, 'message' => "User Already Exists"], 422);
            }
        } else {
            return response()->json(['error'=> true, 'message' => "ID Dont Registered"], 422);
        }
    }

















}
