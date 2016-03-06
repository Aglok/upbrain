<?php namespace App\Models;

use SleepingOwl\Models\SleepingOwlModel;

class Process extends SleepingOwlModel
{
    protected $table = 'processes';
    protected $fillable = ['user_id','number_task','stage','experience','gold','rating','comment','number_lesson'];
}
