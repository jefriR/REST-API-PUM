<?php

namespace App\Http\Controllers\API;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;

class UserController extends Controller
{
    public $successStatus = 200;

    public function login(Request $request){
        $validator = Validator::make($request->all(),[
            'email'     => 'required',
            'password'  => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        dd(Auth::attempt(['email' => request('email'), 'password' => request('password')]));

        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
            $user = Auth::user();
            $users   = DB::table('users')->leftJoin('departments', 'users.dept_id', '=', 'departments.id')->where('users.id','=',$user->id)->get();
            $success['token'] =  $user->createToken('nApp')->accessToken;
            return response()->json(['success' => $users, $success], $this->successStatus);

//            return response()->json(['success'=>$users], $this->successStatus);
        }
        else{
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required| MIN : 5',
            'email' => 'required|email',
            'password' => 'required | MIN : 6',
            'c_password' => 'required|same:password',
            'dept_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
//        $success['token'] =  $user->createToken('nApp')->accessToken;
        $success['name'] =  $user->name;
        $success['dept_id'] =  $user->dept_id;

        return response()->json(['success'=>$success], $this->successStatus);
    }

    public function details()
    {
//        $user = Auth::user();

        $user = User::all();
        return response()->json(['success' => $user], $this->successStatus);

//        $users   = DB::table('users')->leftJoin('departments', 'users.dept_id', '=', 'departments.id')->get();
//        $user   = User::all();
//        $dept_id= $user->name;
//        $depart = DB::select("select * from department where dept_id = $dept_id");

//        return response()->json(['success'=>$users], $this->successStatus);
    }
}
