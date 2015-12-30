<?php

Admin::model(App\Models\Task::class)->title('Задачи')->with('subject')->filters(function ()
{

})->columns(function ()
{
	Column::string('number_task', 'Number_task');
	Column::image('image')->sortable(false);
	Column::string('experience', 'Experience');
	Column::string('gold', 'Gold');
	Column::string('grade', 'Grade');
	Column::string('subject.name', 'Subject')->append(Column::filter('subject_id')->value('subject_id'));
	Column::string('answer', 'Answer');
	Column::string('detail', 'detail');
	Column::string('set_of_task', 'Set_of_task');
})->form(function ()
{
	FormItem::text('number_task', 'Number Task');
	FormItem::image('image', 'Image');
	FormItem::text('experience', 'Experience');
	FormItem::text('gold', 'Gold');
	FormItem::text('grade', 'Grade');
	FormItem::select('subject_id', 'Subject')->list(App\Models\Subject::class);
	FormItem::text('answer', 'Answer');
	FormItem::text('detail', 'detail');
	FormItem::text('set_of_task', 'Set Of Task');
});