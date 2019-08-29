<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Money extends Model
{
    protected $table = 'pum_upload_temp';

    protected $fillable = [
        'emp_num', 'name','dept_id','dept'
    ];



}
