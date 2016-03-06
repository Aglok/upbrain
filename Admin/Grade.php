<?php

Admin::model(App\Models\Grade::class)->title('')->with()->filters(function ()
{

})->columns(function ()
{

})->form(function ()
{
	FormItem::checkbox('subject_id', 'Subject');
	FormItem::checkbox('user_id', 'User');
	FormItem::checkbox('sum', 'Sum');
	FormItem::checkbox('full', 'Full');
	FormItem::checkbox('time', 'Time');
	FormItem::checkbox('number_lesson', 'Number Lesson');
	FormItem::checkbox('experience', 'Experience');
	FormItem::checkbox('gold', 'Gold');
	FormItem::text('grade_char', 'Grade Char');
});