<?php

namespace App\Http\Controllers;

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

        if ($validator->fails()) {
            return response()->json(['error'=>true, 'message' => $validator->errors()], 401);
        }

//        $nik         = $request->emp_num;
//        $cekId       = DB::select("select * from users where emp_num like '$nik'");
//        if($cekId == null){
//            return response()->json(['error' => false,'message' => "User Not Exist"],302);
//        }

        $credentials = [
            'emp_num'  => $request['emp_num'],
            'password' => $request['password'],
        ];

//        dd($credentials);

        dd(Auth::attempt(['emp_num' => request('emp_num'), 'password' => request('password')]));

        if(Auth::attempt(['emp_num' => '1992000044', 'password' => request('password')])){
            // $user = Auth::user();
            // $users   = DB::table('users')->leftJoin('hr_departments', 'users.dept_id', '=', 'hr_departments.dept_id')->where('users.user_id','=',$user->user_id)->get();
            // $success['token'] =  $user->createToken('nApp')->accessToken;
            // return response()->json(['success' => $users, $success], $this->successStatus);
            return response()->json(['error' => false,'message' => "Login Successfully"],200);
        }
        else{
            return response()->json(['error' => true,'message' => "Something's Error"],422);
        }

//        $cekPassword = password_verify($request->password,$cekId[0]->PASSWORD);

//        if ($cekId > 0 && $cekPassword == true) {
//            $user = Auth::user();
//            $return = DB::table('hr_employees')->where('emp_num',$nik)->get();
//            return response()->json(['error' => false,'message' => "Login Successfully", 'user' => $return[0]],200);
//        } elseif($cekPassword == false){
//            return response()->json(['error' => false,'message' => "Password Not Match"],302);
//        }elseif ($cekId == null) {
//            return response()->json(['error'=>'Unauthorised'],422);
//        } else{
//            return response()->json(['error' => true,'message' => "Something's Error"],422);
//        }
    }

    public function register(Request $request){

        return 0;
    }

















}
