<?php

Admin::model(App\Models\Category_Subject::class)->title('Раздел')->with('parent_category')->filters(function ()
{
    ModelItem::filter('parent_category_id')->title()->from('App\Models\Category_Subject', 'name');
})->columns(function ()
{
	Column::string('name', 'Name');
    Column::string('parent_category.name', 'Category_Subject')->append(Column::filter('parent_category_id')->value('parent_category_id'));
	Column::string('code', 'Code');
})->form(function ()
{
	FormItem::text('name', 'Name');
    FormItem::select('parent_category_id', 'Parent')->list(App\Models\Category_Subject::class);
	FormItem::text('code', 'Code');
});