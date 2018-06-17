<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

/**
* REST API
*/
Route::group(array('prefix' => 'api'), function() {
	Route::get('/', function () {
		return Response::json(array('message' => 'Tasks API', 'status' => 'Connected'));
	});

	Route::get('/tasks', 		 array('as' => 'tasks_list',   'uses' => 'TaskController@retrieve'));
	Route::get('/tasks/{id}', 	 array('as' => 'tasks_view',   'uses' => 'TaskController@view'));
	Route::post('/tasks', 		 array('as' => 'tasks_store',  'uses' => 'TaskController@store'));
	Route::put('/tasks/{id}', 	 array('as' => 'tasks_update', 'uses' => 'TaskController@update'));
	Route::delete('/tasks/{id}', array('as' => 'tasks_delete', 'uses' => 'TaskController@delete'));
});

Route::get('/', function () {
	return Redirect::route('tasks_list');
});

Route::get('/uiexample', array('as' => 'uiexample', 'uses' => 'TaskController@uiexample'));
