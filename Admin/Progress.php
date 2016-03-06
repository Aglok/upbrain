<?php

Admin::model(App\Models\Progress::class)->title('Достижения')->with()->filters(function ()
{

})->columns(function ()
{
	Column::image('image')->sortable(false);
	Column::string('name', 'Название');
	Column::string('alias', 'Кратко');
	Column::string('description', 'Описание');
})->form(function ()
{
	FormItem::image('image', 'Изображение');
	FormItem::text('name', 'Название');
	FormItem::text('alias', 'Кратко');
	FormItem::ckeditor('description', 'Описание');
});