<?php namespace App\Models;

use SleepingOwl\Models\SleepingOwlModel;

class Process extends SleepingOwlModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'processes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id','number_task','stage','experience','gold','rating','comment','number_lesson'];
}
