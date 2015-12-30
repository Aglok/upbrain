<?php namespace App\Http\Controllers;

use SleepingOwl\Admin\Controllers\AdminController;
use App;
use Illuminate\Http\Request;
use Input;
use View;
use Session;
/**
 * Created by PhpStorm.
 * User: artemperlov
 * Date: 28.12.15
 * Time: 1:09
 */


class ProcessController extends AdminController
{
    public function getIndex(){

        $this->modelName = 'tasks';
        $this->getModelItem();
        $request = new Request;
        $this->modelRepository = App::make('SleepingOwl\Admin\Repositories\Interfaces\ModelRepositoryInterface', [
            'modelItem' => $this->modelItem,
            'request'   => $request
        ]);

        return $this->create();
    }
    protected function makeView($name, $data = [])
    {
        $view = View::make($name, $data);
        $this->addViewDefaults($view);
        return $view;
    }

    public function table()
    {
        if ($result = $this->checkCustomActionCall())
        {
            return $result;
        }
        if (Input::get('datatable_request'))
        {
            return $this->asyncTable();
        }
        $this->queryState->save();
        $data = [
            'title'         => $this->modelItem->getTitle(),
            'columns'       => $this->modelItem->getColumns(),
            'newEntryRoute' => $this->admin_router->routeToCreate($this->modelName, Input::query()),
            'modelItem'     => $this->modelItem,
            'rows'          => []
        ];
        //var_dump($data);
        if ( ! $this->modelItem->isAsync())
        {
            $tableData = [];
            try
            {
                $tableData = $this->modelRepository->tableData();
            } catch (ModelNotFoundException $e)
            {
                App::abort(404);
            }
            $data = array_merge($data, $tableData);
        }
        $data['subtitle'] = $this->modelRepository->getSubtitle();
        return $this->makeView('process.main', $data);
    }

    public function create()
    {
        if ( ! $this->modelItem->isCreatable())
        {
            return $this->redirectToTable();
        }
        $form = $this->modelItem->getForm();
        $form->setInstance($this->modelRepository->getInstance());
        $form->setMethod('post');
        $form->setSaveUrl($this->admin_router->routeToStore($this->modelName));
        $form->setErrors(Session::get('errors'));
        $form->setBackUrl($this->redirectToTable()->getTargetUrl());
        $form->setValues(Input::query());

        $data = [
            'title' => $this->modelItem->getTitle(),
            'form'  => $form
        ];
        return $this->makeView('process.form', $data);
    }
}