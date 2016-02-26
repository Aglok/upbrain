<?php

/*
 * Создание и редактирование статей.
 * Файл Post.php
 */

Admin::model('App\Models\Post')->title('Article')
    ->filters(function ()
    {
        ModelItem::filter('PostForId')->scope('PostForId')->title('От 3 до 5');
    })
    ->columns(function()
    {
        Column::string('link', 'Link');
        Column::string('header', 'Header');
        Column::string('article', 'Article');
        Column::string('author', 'Author');
        Column::string('created_at', 'Created_at');
        Column::string('updated_at', 'Updated_at');
    })
    ->form (function ()
    {
        FormItem::text('link', 'Link')->required();
        FormItem::text('header', 'Header')->required();
        FormItem::ckeditor('article', 'Article')->required();
        FormItem::text('author', 'Author')->required();
        FormItem::timestamp('created_at', 'Created_at')->required();
        FormItem::timestamp('updated_at', 'Updated_at')->required();

    });