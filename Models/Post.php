<?php namespace App\Models;

use Auth;
use illuminate\Support\Str;
use SleepingOwl\Models\SleepingOwlModel;

class Post extends SleepingOwlModel {

    protected $table = 'posts';
    //Добавляем в выдачу вычисляемое поле
    protected $appends = array('cut');//регистрируем метод getCutAttribute()(Cut вставляется между get и Attribute), и создает поле которого нет в таблице БД.
    //Делаем поля доступными для автозаполнения
    protected $fillable = array('header', 'link', 'article', 'author');

    public function getCutAttribute(){
        return Str::limit($this->attributes['article'], 120);//ограничивает по количеству символов
    }

    public function getValidator(){
        //массив со статистическими данными
        $validation = array(
            'header' => 'required|max:256',
            'link' => 'required|between:2,32',
            'article' => 'required'
        );

        return $validation;
    }

        //Сохраняем данные в БД и возвращаем эти данные ввиде объекта
    public function savePostDb($data){
        try {
            if (Auth::check()) {
                $data['user_id'] = Auth::user()->id;
            }
            $post = Post::create([
                'header' => $data['header'],
                'link' => $data['link'],
                'article' => $data['article'],
                'author' => Auth::user()->name
            ]);

        }catch (Exception $e) {
            return $e;
        }
        return $post;
    }

    public function scopePostForId($query)
    {
        return $query->where('id', '>', '3');
    }
/*    public function author() {
        return $this->belongsTo('User', 'user_id');
    }*/
}
