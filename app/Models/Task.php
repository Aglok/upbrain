<?php namespace App\Models;

//use Illuminate\Auth\Authenticatable;
//use Illuminate\Support\Str;
//use Illuminate\Database\Eloquent\Model;
//use Illuminate\Auth\Passwords\CanResetPassword;
//use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
//use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use SleepingOwl\Models\Interfaces\ModelWithImageFieldsInterface;
use SleepingOwl\Models\SleepingOwlModel;
use SleepingOwl\Models\Traits\ModelWithImageOrFileFieldsTrait;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Task extends SleepingOwlModel implements ModelWithImageFieldsInterface  {

    use ModelWithImageOrFileFieldsTrait;

    public $timestamps = false;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tasks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
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