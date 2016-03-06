<?php

namespace App\Models;

use SleepingOwl\Models\Interfaces\ModelWithImageFieldsInterface;
use SleepingOwl\Models\SleepingOwlModel;
use SleepingOwl\Models\Traits\ModelWithImageOrFileFieldsTrait;

class Set_Of_Task extends SleepingOwlModel implements ModelWithImageFieldsInterface
{
    use ModelWithImageOrFileFieldsTrait;

    protected $table = 'set_of_tasks';
    protected $fillable = ['name','alias','image','type','description','created_at','updated_at'];

    public function getImageFields()
    {
        return [
            'image' => ['set_of_tasks/', function($directory, $originalName, $extension)
            {
                //выводит оригинальное название рисунка. По умолчанию название рисунков random
                return $originalName;
            }]
        ];
    }
}
