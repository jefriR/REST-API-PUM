<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Pumtemp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CreatePumController extends Controller
{
    public function createTemp(Request $request){
        $validator = Validator::make($request->all(), [
            'emp_name'      => 'required | string'
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>true, 'message' => "Something Error's"], 401);
        }

        //Get id Employ
        $emp_id = DB::table('hr_employees')->select('emp_id')->where('name',$request->emp_name)->get();
        $emp_id = $emp_id[0]->{'emp_id'};

        $data   = new Pumtemp();
        $data->emp_id  = $emp_id;
        $data->save();
    }

    public function updateReq1(Request $request){
        $validator = Validator::make($request->all(), [
            'emp_dept'      => 'required',
            'use_date'      => 'required | date',
            'resp_date'     => 'required | date',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=>true, 'message' => "Something Error's"], 401);
        }

        //Get id Department
        $dept_id = DB::table('hr_departments')->select('dept_id')->where('name',$request->emp_dept)->get();
        $dept_id = $dept_id[0]->{'dept_id'};


    }
}
