<?php

Admin::model(App\Models\Subject::class)->title('Темы')->with('category')->filters(function ()
{
    ModelItem::filter('category_id')->title()->from('App\Models\Category_Subject', 'name');
})->columns(function ()
{
	Column::string('name', 'Name_subject');
    //category.name обращение к методу category в модели Category_Subject с добавлением фильтра по category_id выборка из Category_Subject
    Column::string('category.name', 'Category_Subject')->append(Column::filter('category_id')->value('category_id'));
	Column::string('code', 'Code');
})->form(function ()
	FormItem::text('name', 'Name Subject');
	FormItem::select('category_id', 'Category')->list(App\Models\Category_Subject::class);
	FormItem::text('code', 'Code');
});