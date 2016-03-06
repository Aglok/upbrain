<?php namespace App\Http\Controllers;

use SleepingOwl\Admin\Controllers\AdminController;
use App\Models\Task;
use App\Models\Set_Of_Task;
use App\Models\User;
use App\Models\Stage;
use App\Models\Progress;
use App\Models\User_Progress;
use App\Models\Process;
use App\Models\Grade;
use AdminAuth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Contracts\Routing\ResponseFactory as Response;

/**
 * Created by PhpStorm.
 * User: artemperlov
 * Date: 28.12.15
 * Time: 1:09
 */


class ProcessController extends AdminController

{
    /**
     * @var integer
     * @return View
     * */
    public function getTable($set_id)
    {
        //Набор названия столбцов для таблицы: возможно брать список из таблицы и перевод включать в lang
        $columns = [
            'id' => 'Выбрать' ,
            'number_task'=> 'Номер задачи' ,
            'image' => 'Задача' ,
            'experience' => 'Опыт' ,
            'gold' => 'Монет',
            'grade' => 'Уровень сложности',
            'subject_id' => 'id предмета',
            'rating' => 'Уровень значимости' ,
            'comment' => 'Комментарий'
        ];

        $rows = DB::table('tasks')
            ->select(['id','number_task','image','experience','gold', 'grade', 'subject_id'])
            ->where('set_of_task', '=', $set_id)
            ->orderBy('id', 'ASC')
            ->get();
        $count = Task::count();
        //Выбор номера уникальной группы: возможно просто записать в html статично
        $group = DB::table('users')->select(DB::raw('DISTINCT `group`'))->orderBy('group')->get();

        return view('process.table', [
            'count' => $count,
            'columns' => $columns,
            'rows' => $rows,
            'group' => $group,
            'adminTitle' => 'Административная панель',
            'user' => AdminAuth::user(),
            'menu' => $this->admin->menu->getItems(),
            'pageTitle' => ''
        ]);
    }
    /**
     * @param Request $request
     * @param Response $response
     * @return Object
     * Принимаем ajax запрос формат json - массив объектов и отправляем текст о успешном добавлении
     * */
    public function saveProcess(Request $request, Response $response)
    {
        if($request->ajax()) {
            $result = $request->get('json');
            $result = json_decode($result);
            $arr = [];
            //Поставить заглушку на проверку выбранной опции, как свойства объекта
            $userObject = $result->user;
            //$group = $userObject->group;
            $user = $userObject->users;
            $stage = $userObject->stages;
            $progress_id = $userObject->user_progress;
            $number_lesson = $userObject->number_lesson;
            $exp_progress = $userObject->exp_progress;

            User_Progress::create([
                'progress_id' => $progress_id,
                'user_id' => $user,
                'experience' => $exp_progress,
                //'description' => $description
                //'gift' => $gift,
            ]);

            foreach($result as $key => $value){

                if($key == 'D'|| $key == 'C'||$key == 'B'||$key == 'A'){
                    array_push($arr, $value);

                    for ($i = 0; $i < count($value); $i++) {
                        $grade_char = $value[$i]->grade;
                        $subject_id = $value[$i]->subject_id;
                        $experience = $value[$i]->sumExp;
                        $gold = $value[$i]->sumGold;
                        $sumTask = $value[$i]->sumTask;

                        Grade::create([
                            'subject_id' => $subject_id,
                            'user_id' => $user,
                            'grade_char' => $grade_char,
                            'sum_tasks' => $sumTask,
                            //'full' => $full,
                            'number_lesson' => $number_lesson,
                            'sum_exp' => $experience,
                            //'time' => $time,
                            'sum_gold' => $gold,
                        ]);
                    }
                }

                if($key == 'task'){
                    for ($i = 0; $i < count($value); $i++) {
                        //$id = $value[$i]->id;
                        $number_task = $value[$i]->number_task;
                        $experience = $value[$i]->experience;
                        $gold = $value[$i]->experience;
                        $rating = $value[$i]->rating;
                        $comment = $value[$i]->comment;

                        Process::create([
                            'user_id' => $user,
                            'stage' => $stage,
                            'number_task' => $number_task,
                            'experience' => $experience,
                            'gold' => $gold,
                            'rating' => $rating,
                            'comment' => $comment,
                            'number_lesson' => $number_lesson,
                        ]);
                    }
                }
            }

            return $response->json(['Задачи успешно добавились в БД', $arr]);
        }

    }

    /**
     * @param Request $request
     * @param Response $response
     * @return object
     * Принимаем ajax запрос из списка групп id, отправляем список учеников в группе
     * */
    public function getUsers(Request $request, Response $response)
    {
        if($request->ajax()){
            $id = $request->get('id');
            $query = User::select(['name', 'surname'])->where('group', '=', $id)->get();
            $param = (object)['idNameSelect' => 'users', 'url' => 'user', 'prop' => ['name', 'surname']];

            return $response->json([$query, $param]);
        }
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Object
     * */
    public function getStages(Request $request, Response $response)
    {
        if($request->ajax()){
            $query = Stage::select(['name', 'alias'])->get();
            $param = (object)['idNameSelect' => 'stages', 'url' => 'stage', 'prop' => ['name', 'alias']];
            return $response->json([$query, $param]);
        }
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Object
     * */
    public function getProgress(Request $request, Response $response)
    {
        if($request->ajax()){
            $query = Progress::select(['name', 'alias'])->get();
            $param = (object)['idNameSelect' => 'user_progress', 'url' => 'user_progress', 'prop' => ['name', 'alias']];
            return $response->json([$query, $param]);
        }
    }

    /**
     * @param Request $request
     * @param Response $response
     * @return Object
     * */
    public function userProgress(Request $request, Response $response)
    {
        if($request->ajax()){
            $id = $request->get('id');
            $query = Progress::select(['name', 'alias'])->where('id', '=', $id)->get();
            $param = 'progress';

            return $response->json([$query, $param]);
        }
    }

    /**
     * @return View
     * */
    public function getSetOfTasks()
    {
        $count = Set_Of_Task::count();
        //Набор названия столбцов для таблицы: возможно брать список из таблицы и перевод включать в lang
        $columns = [
            'name' => 'Набор задач',
            'tasks_count' => 'Количество задач',
            'sum_experience' => 'Суммарный опыт',
            'sum_gold' => 'Сумма монет',
        ];

        $rows = DB::table('tasks')
            ->leftJoin('set_of_tasks', 'tasks.set_of_task', '=', 'set_of_tasks.id')
            ->select(DB::raw('count(*) as tasks_count, set_of_tasks.name, tasks.set_of_task as set_id, sum(tasks.experience) as sum_exp, sum(tasks.gold) as sum_gold'))
            ->groupBy('set_of_task')
            ->get();

        return view('process.set_of_tasks', [
            'count' => $count,
            'columns' => $columns,
            'rows' => $rows,
            'adminTitle' => 'Административная панель',
            'user' => AdminAuth::user(),
            'menu' => $this->admin->menu->getItems(),
            'pageTitle' => ''
        ]);
    }


}