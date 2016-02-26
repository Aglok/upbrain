<?php

namespace App\Models;

use SleepingOwl\Models\SleepingOwlModel;

class Grade extends SleepingOwlModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'grade';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['subject_id','user_id','grade_char','sum','full','time','number_lesson','experience','gold','created_at','updated_at'];
}
