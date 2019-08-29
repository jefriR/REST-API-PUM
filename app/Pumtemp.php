<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pumtemp extends Model
{
    protected $table = 'pum_upload_temp';

    protected $fillable = [
        'emp_id','dept_id', 'use_date','resp_date','po_number', 'pum_trx_type_id','request_desc','curr_code', 'amount','upload_data',
    ];
}
