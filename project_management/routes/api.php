<?php

use App\Http\Controllers\AnnouncementsController;
use App\Http\Controllers\UserController;
use App\Project_Todos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Http\Controllers\AccessTokenController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::post('login', [AccessTokenController::class, 'issueToken'])->middleware(['api-login', 'throttle']);

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
// Route::post('login',)
//login and registration does not need token
Route::post('register', 'AuthController@register');
Route::post('login', 'AuthController@login');


//need token
Route::middleware('auth:api')->group(function () {
    //user
    Route::get('userList', 'UserController@userList');
    Route::get('user/{userId}/detail', 'UserController@show');
    Route::post('user/edit', 'UserController@edit');
    Route::post('user/updatepassword/{userId}', 'UserController@updatePass');
    Route::get('userProject/{userId}', 'UserController@userProject');
    Route::put('user/updateRole/{userId}', 'UserController@updateRole');

    //Budget
    Route::get('budgetList', 'BudgetsController@budgetList');
    Route::get('budgetDetail/{budgetId}', 'BudgetsController@show');
    Route::put('budgetDetail/editBudget/{budgetId}', 'BudgetsController@editBudget');

    //Expenses
    Route::post('expenses/createExpenses', 'ExpensesController@addExpenses');
    Route::put('expenses/editExpenses/{expensesId}', 'ExpensesController@editExpenses');
    Route::delete('deleteExpenses/{expensesId}/{budgetId}', 'ExpensesController@deleteExpenses');
    //Projects
    Route::get('projectList', 'ProjectsController@projectList');
    Route::post('createProject', 'ProjectsController@add');
    Route::get('projectDetail/{projectId}/{userId}', 'ProjectsController@projectDetail');
    Route::put('changeManager/{projectId}', 'ProjectsController@changeManager');
    Route::post('joinProject', 'ProjectsController@joinProject');
    Route::post('leaveProject/', 'ProjectsController@leaveProject');
    Route::delete('deleteProject/{projectId}', 'ProjectsController@deleteProject');
    Route::put('editProject/{projectId}', 'ProjectsController@editProject');
    Route::get('projectMembers/{projectId}', 'ProjectsController@listMembers');
    //Announcements
    Route::get('announcement/{id}/detail', 'AnnouncementsController@show');
    Route::post('announcement/edit', 'AnnouncementsController@edit');
    Route::get('announceList', 'AnnouncementsController@announceList');
    Route::post('annoucementAdd', 'AnnouncementsController@add');
    Route::delete('deleteAnnouncement/{announcementId}', 'AnnouncementsController@delete');
    //Project Todos
    Route::get('projectTask/{projectId}', 'ProjectTodosController@taskList');
    Route::post('projectTaskCreate/', 'ProjectTodosController@addTask');
    Route::put('editTask/{taskId}', 'ProjectTodosController@editTask');
    Route::put('setComplete/{taskId}', 'ProjectTodosController@setTaskComplete');
    Route::put('setIncomplete/{taskId}', 'ProjectTodosController@setTaskIncomplete');
    Route::delete('taskDelete/{taskId}', 'ProjectTodosController@taskDelete');
});
