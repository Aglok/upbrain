<?php namespace App\Models;

use SleepingOwl\Models\SleepingOwlModel;

class Subject extends SleepingOwlModel{

    public $timestamps = false;

    protected $table = 'subjects';
    protected $fillable = ['name','category_id','code'];

    public function category()
    {
        return $this->belongsTo('App\Models\Category_Subject');
    }
    /**
     * Метод возвращает список данных тем предмета из для select list.
     *
     * @return array
     */
    public static function getList(){

        return static::lists('name', 'id')->toArray();
    }
}
