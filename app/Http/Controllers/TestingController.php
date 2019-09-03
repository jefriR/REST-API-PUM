<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers\PumController;

use App\Employees;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//use App\Http\Controllers\PumController\CekApprovalController;

class TestingController extends Controller
{
    public function testing(){
//        $nik    = DB::table('hr_employees')->select("emp_num")->where('name', 'SUGIANTO')->get();
//        $pinUser= DB::table('users')->select('pin')->where('emp_num',$nik[0]->emp_num)->get();

        $cekApproval    =  \App\Http\Controllers\PumController\CekApprovalController::cekStatusPum(99216,1500000);
//        $cekApproval    =  app('App\Http\Controllers\PumContoller\CekApprovalController')->cekStatusPum(99216,1500000);
//            DB::select("SELECT * FROM PUM_APP_HIERAR WHERE EMP_ID = 99216 AND 1500000 BETWEEN PROXY_AMOUNT_FROM AND PROXY_AMOUNT_TO");

        dd($cekApproval);
    }
}
