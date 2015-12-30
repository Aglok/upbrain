<?php namespace App\Models;

use SleepingOwl\Models\SleepingOwlModel;

class Category_Subject extends SleepingOwlModel{

    public $timestamps = false;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'categories_subjects';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','parent','code'];

    public function parent_category()
    {
        return $this->belongsTo('App\Models\Category_Subject','parent_category_id');
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
