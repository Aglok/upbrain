<?php

Admin::model(App\Models\Stage::class)->title('Этапы работы')->with()->filters(function ()
{

})->columns(function ()
{
	Column::string('id', '№');
	Column::string('name', 'Название');
	Column::string('alias', 'Кратко');
	Column::string('description', 'Описание');
})->form(function ()
{
	FormItem::text('name', 'Название');
	FormItem::text('alias', 'Кратко');
	FormItem::ckeditor('description', 'Описание');
});