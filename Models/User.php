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

class User extends SleepingOwlModel implements ModelWithImageFieldsInterface  {

	//use Authenticatable, CanResetPassword;
	use ModelWithImageOrFileFieldsTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name','login','email', 'password', 'avatar', 'surname', 'description', 'group'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

	public function getImageFields()
    {
        return [
            'avatar' => 'avatar/'
        ];
    }
}
