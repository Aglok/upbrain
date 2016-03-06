<?php namespace App\Models;

use SleepingOwl\Models\SleepingOwlModel;

class User_Progress extends SleepingOwlModel
{
    protected $table = 'users_progress';
    protected $fillable = ['progress_id','user_id','experience','description','gift'];
}
