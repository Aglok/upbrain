<?php namespace App\Models;

use SleepingOwl\Models\SleepingOwlModel;

class Stage extends SleepingOwlModel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'stages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','alias','description'];

}
