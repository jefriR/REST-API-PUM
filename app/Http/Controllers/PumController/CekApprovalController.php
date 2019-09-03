<?php

namespace App\Http\Controllers\PumController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CekApprovalController extends Controller
{
    public function cekStatusPum($emp_id, $amount){
        $cekApproval    = 'HALLO';
//        $cekApproval    = DB::select("SELECT * FROM PUM_APP_HIERAR WHERE EMP_ID = '$emp_id' AND '$amount' BETWEEN PROXY_AMOUNT_FROM AND PROXY_AMOUNT_TO");

        return $cekApproval;

    }
}
