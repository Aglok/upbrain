<?php namespace App\Http\Controllers;

use Validator, Input, Redirect, Auth;
use App\Models\Post; //Добавляем класс post модели в из папки App/post.php
class BlogController extends Controller {


    /**
     * Create a new controller instance.
     *
     * @return void
     */

        public function __construct(){
            return view('app');//по умолчанию будет использоватсья шаблон layout.blade.php
        }

        public function showList()
        {
            $count = Post::count();
            $posts = Post::orderBy('created_at', 'DESC')->take(6)->get();
            return view('list', ['count' => $count, 'posts' => $posts]);//будет использоваться list.blade.php
        }

        public function showPost($link)
        {
            $post = Post::where('link', '=', $link)->firstOrFail();//есть метод link и он должен равняться значению поля link из БД который приходит через get
            return view('post', $post);//будет использоваться post.blade.php, переменную $post передает в шаблон, в которой переменные являются поля БД
        }
        public function addPost()
        {
            return view('add');
        }
        public function addPostMsg($id)
        {
            $msg = Post::where('id', '=', $id)->firstOrFail();
            return view('msg', $msg);
        }
        //Добавление данных через форму методом post
        public function savePost()
        {
            //соберет все данные из формы и закинет в переменную $data
            $data = Input::all();
            //Проверяем корректность введённых данных
            $validation = Validator::make($data, Post::getValidator());

            //Если данные не корректы, то возвращаем пользователя обратно без потерь данных
            if ($validation->fails()){
                return Redirect::back()->withErrors($validation)->withInput();
            }

            //Сохраняем в БД
            $post = Post::savePostDb($data);

            if($post instanceof Exeption)
            {
                return 'error';
            }
            return Redirect::to("/blog/".$post->link);
        }
}
