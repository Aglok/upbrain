<?php namespace App\Models;

use SleepingOwl\Models\Interfaces\ModelWithImageFieldsInterface;
use SleepingOwl\Models\SleepingOwlModel;
use SleepingOwl\Models\Traits\ModelWithImageOrFileFieldsTrait;

class User extends SleepingOwlModel implements ModelWithImageFieldsInterface  {

	use ModelWithImageOrFileFieldsTrait;

	protected $table = 'users';
	protected $fillable = ['name','login','email', 'password', 'avatar', 'surname', 'description', 'group'];
	protected $hidden = ['password', 'remember_token'];

	public function getImageFields()
    {
        return [
            'avatar' => 'avatar/'
        ];
    }
}
