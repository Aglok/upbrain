<?php namespace App\Models;

use SleepingOwl\Models\SleepingOwlModel;

class Stage extends SleepingOwlModel
{
    protected $table = 'stages';
    protected $fillable = ['name','alias','description'];

}
