<?php

/*
 * This is a simple example of the main features.
 * For full list see documentation.
 */

Admin::model('App\Models\User')->title('Users')
	->columns(function()
	{
		Column::image('avatar');
		Column::string('name','Имя');
		Column::string('surname','Фамилия');
		Column::string('login','Login');
		//Column::string('email', 'Email');
		Column::string('description','Описание');
		Column::string('group','Номер группы');
	})
	->form(function ()
	{
		FormItem::image('avatar', 'Аватар');
		FormItem::text('name', 'Имя')->required();
		FormItem::text('surname','Фамилия')->required();
		FormItem::text('login','Login');
		FormItem::text('email', 'Email')->unique();
		FormItem::text('password', 'Пароль')->unique();
		FormItem::textarea('description','Описание');
		FormItem::text('group','Номер группы');
	});