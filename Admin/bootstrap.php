<?php

/*
 * Describe you custom displays, columns and form items here.
 *
 *		Display::register('customDisplay', '\Foo\Bar\MyCustomDisplay');
 *
 *		Column::register('customColumn', '\Foo\Bar\MyCustomColumn');
 *
 * 		FormItem::register('customElement', \Foo\Bar\MyCustomElement::class);
 *
 */
//AdminRouter::post('students/{student_id}/edit', '\App\Models\Student');
AdminRouter::post('process/group', ['as' => 'group','uses'=>'\App\Http\Controllers\ProcessController@getUsers']);
AdminRouter::post('process/user', ['as' => 'user','uses'=>'\App\Http\Controllers\ProcessController@getStages']);
AdminRouter::post('process/stage', ['as' => 'stage','uses'=>'\App\Http\Controllers\ProcessController@getProgress']);
AdminRouter::post('process/task', ['as' => 'task','uses'=>'\App\Http\Controllers\ProcessController@getTasks']);
AdminRouter::post('process/user_progress', ['as' => 'user_progress','uses'=>'\App\Http\Controllers\ProcessController@userProgress']);
AdminRouter::get('process/{set_id}', ['as' => 'process/{set_id}','uses'=>'\App\Http\Controllers\ProcessController@getTable']);
AdminRouter::post('process/save', ['as' => 'save','uses'=>'\App\Http\Controllers\ProcessController@saveProcess']);