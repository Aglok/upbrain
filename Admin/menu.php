<?php

Admin::menu()->url('/')->label('Start Page')->icon('fa-dashboard');
Admin::menu('App\Models\User')->label('Ученики')->icon('fa-users');
Admin::menu('App\Models\Task')->label('Задачи')->icon('fa-tasks');
Admin::menu('App\Models\Set_Of_Task')->label('Набор задач')->icon('fa-list-alt');
Admin::menu('App\Models\Subject')->label('Темы')->icon('fa-list');
Admin::menu('App\Models\Stage')->label('Этапы')->icon('fa-circle-o');
Admin::menu('App\Models\Progress')->label('Достижения')->icon('fa-circle');
Admin::menu('App\Models\Category_Subject')->label('Категории')->icon('fa-outdent');
Admin::menu()->label('Subitems')->icon('fa-book')->items(function ()
{
    Admin::menu('App\Models\Post')->label('Статьи')->icon('fa-fire');
    Admin::menu('App\Models\Process')->label('Процесс')->icon('fa-user');
    Admin::menu()->url('setoftask')->label('Список набора')->icon('fa-user')->uses('App\Http\Controllers\ProcessController@getSetOfTasks');
});