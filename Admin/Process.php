<?php

Admin::model(App\Models\Process::class)->title('')->with()->filters(function ()
{

})->columns(function ()
{
	Column::string('user_id', 'User');
	Column::string('stage', 'Stage');
	Column::string('number_task', 'Task');
	Column::string('experience', 'Experience');
	Column::string('gold', 'Gold');
	Column::string('number_lesson', 'Number Lesson');
	Column::string('rating', 'Rating');
	Column::string('comment', 'Comment');

})->form(function ()
{
	FormItem::text('user_id', 'User');
	FormItem::text('stage', 'Stage');
	FormItem::text('number_task', 'Task');
	FormItem::text('experience', 'Experience');
	FormItem::text('gold', 'Gold');
	FormItem::text('number_lesson', 'Number Lesson');
	FormItem::text('rating', 'Rating');
	FormItem::ckeditor('comment', 'Comment');
});