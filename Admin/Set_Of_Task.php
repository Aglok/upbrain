<?php

Admin::model(App\Models\Set_Of_Task::class)->title('')->with()->filters(function ()
{

})->columns(function ()
{
	Column::string('name', 'Название');
	Column::string('alias', 'Кратко');
	Column::image('image')->sortable(false);
	Column::string('type', 'Тип');
	Column::string('description', 'Описание');
})->form(function ()
{
	FormItem::text('name', 'Название');
	FormItem::text('alias', 'Кратко');
	FormItem::image('image', 'Изображение');
	FormItem::text('type', 'Тип');
	FormItem::ckeditor('description', 'Описание');
});