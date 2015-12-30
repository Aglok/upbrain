<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'WelcomeController@index');
Route::get('/home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
Route::get('/blog/', array(
            'as' => 'posts_list',//создаем псевдоним маршрута
            'uses' => 'BlogController@showList'// указываем контроллер и функцию, где будет использоваться псевдоним маршрута
        ));
Route::get('/blog/{link}', array(
            'as' => 'post',
            'uses' => 'BlogController@showPost'
        ))->where('link', '[A-Za-z-_0-9]+');// регулярное выражение для параметра проверки link
Route::get('/add/{id}', array(
            'as' => 'add_msg',
            'uses' => 'BlogController@addPostMsg'
        ));
Route::get('/add', 'BlogController@addPost');
Route::post('/add', array(
            'as' => 'save',
            'uses' => 'BlogController@savePost'
        ));