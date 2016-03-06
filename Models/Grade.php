<?php

namespace App\Models;

use SleepingOwl\Models\SleepingOwlModel;

class Grade extends SleepingOwlModel
{
    protected $table = 'grade';
    protected $fillable = ['subject_id','user_id','grade_char','sum','full','time','number_lesson','experience','gold','created_at','updated_at'];
}
