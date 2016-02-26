<?php

AdminRouter::get('', [
	'as' => 'admin.home',
	function ()
	{
		$content = 'Define your dashboard here.';
		return Admin::view($content, 'Dashboard');
	}
]);

AdminRouter::get('', [
    'as' => 'admin.user',
    function ()
    {
        $content = AdminAuth::user()->name;
        return Admin::view($content, 'Admin');
    }
]);

//Смена шаблона админки(сейчас не работает надо исправлять шаблоны blade в admin-lte.template)
AdminRouter::get('/template/{template}', [
    'as' => 'admin.change-template',
    function ($template)
    {
        if ($template == 0)
        {
            $cookie = cookie('admin-template', $template, -1);
        } else
        {
            $cookie = cookie('admin-template', $template);
        }
        return back()->withCookie($cookie);
    }
]);
AdminRouter::post('group', ['as' => 'group','uses'=>'\App\Http\Controllers\ProcessController@getUsers']);