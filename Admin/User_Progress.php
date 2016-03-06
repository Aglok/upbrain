<?php

Admin::model(App\Models\User_Progress::class)->title('')->with()->filters(function ()
{

})->columns(function ()
{

})->form(function ()
{
	FormItem::checkbox('progress_id', 'Progress');
	FormItem::checkbox('user_id', 'User');
	FormItem::checkbox('experience', 'Experience');
	FormItem::checkbox('gift', 'Gift');
	FormItem::ckeditor('description', 'Description');
});