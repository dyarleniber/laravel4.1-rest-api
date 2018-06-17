<?php

class TaskController extends Controller
{
	public function retrieve()
	{
        $tasks = Task::all();
        
        return Response::json($tasks, 200);
	}

	public function view()
	{
		$rules = array(
			'id' => 'exists:tasks'
		);

		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails()) {
			return Response::json(array('message' => 'Bad Request'), 400);
		}

		$task = Task::find(Input::get('id'));

        return Response::json($task, 200);
	}

	public function store()
	{
		$rules = array(
			'title' => 'required',
			'description' => 'required',
			'priority' => 'between:'.Task::PRIORITY_1.','.Task::PRIORITY_5
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Response::json(array('message' => 'Bad Request'), 400);
		}

        try {
        	DB::beginTransaction();

        	$Task = new Task;
        	$Task->title = Input::get('title');
        	$Task->description = Input::get('description');
        	$Task->priority = Input::get('priority');
        	$Task->save();

            DB::commit();

            return Response::json($Task, 201);
        } catch (Exception $e) {
            DB::rollback();

            return Response::json(array('message' => 'Internal Server Error'), 500);
        }
	}
	
	public function update()
	{
		$rules = array(
			'id' => 'exists:tasks',
			'title' => 'required',
			'description' => 'required',
			'priority' => 'between:'.Task::PRIORITY_1.','.Task::PRIORITY_5
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Response::json(array('message' => 'Bad Request'), 400);
		}

        try {
        	DB::beginTransaction();

        	$Task = Task::find(Input::get('id'));
        	$Task->title = Input::get('title');
        	$Task->description = Input::get('description');
        	$Task->priority = Input::get('priority');
        	$Task->save();

            DB::commit();

            return Response::json($Task, 200);
        } catch (Exception $e) {
            DB::rollback();

            return Response::json(array('message' => 'Internal Server Error'), 500);
        }
	}

	public function delete()
	{
		$rules = array(
			'id' => 'exists:tasks'
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails()) {
			return Response::json(array('message' => 'Bad Request'), 400);
		}

        try {
        	DB::beginTransaction();

        	$Task = Task::find(Input::get('id'));
        	$Task->delete();

            DB::commit();

            return Response::json(array('message' => 'Deleted'), 200);
        } catch (Exception $e) {
            DB::rollback();

            return Response::json(array('message' => 'Internal Server Error'), 500);
        }
	}

	public function uiexample()
	{
		$tasks = DB::table('tasks')
			->orderBy('priority', 'asc')
			->orderBy('created_at', 'desc')
			->paginate(5);

		return View::make('uiexample', array('tasks' => $tasks));
	}
}
