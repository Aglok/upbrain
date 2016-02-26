<?php

namespace App\Models;

use SleepingOwl\Models\Interfaces\ModelWithImageFieldsInterface;
use SleepingOwl\Models\SleepingOwlModel;
use SleepingOwl\Models\Traits\ModelWithImageOrFileFieldsTrait;

class Progress extends SleepingOwlModel implements ModelWithImageFieldsInterface
{
    use ModelWithImageOrFileFieldsTrait;
    /**
     * @var string
     */
    protected $table = 'progress';
    /**
     * @var array
     */
    protected $fillable = ['id','name','alias','description','image','created_at','updated_at'];

    public function getImageFields()
    {
        return [
            'image' => ['progress/', function($directory, $originalName, $extension)
            {
                //выводит оригинальное название рисунка. По умолчанию название рисунков random
                return $originalName;
            }]
        ];
    }
}
