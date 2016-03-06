<?php namespace App\Models;

use SleepingOwl\Models\Interfaces\ModelWithImageFieldsInterface;
use SleepingOwl\Models\SleepingOwlModel;
use SleepingOwl\Models\Traits\ModelWithImageOrFileFieldsTrait;

class Task extends SleepingOwlModel implements ModelWithImageFieldsInterface  {

    use ModelWithImageOrFileFieldsTrait;

    public $timestamps = false;

    protected $table = 'tasks';
    protected $fillable = ['number_task','image','experience','gold','grade','answer','detail','subject_id','set_of_task'];

    public function subject()
    {
        return $this->belongsTo('App\Models\Subject');
    }

    public function getImageFields()
    {
        return [
            'image' => ['tasks/', function($directory, $originalName, $extension)
            {
                return $originalName;//выводит оригинальное название рисунка. По умолчанию название рисунков random
            }]
        ];
    }
}
