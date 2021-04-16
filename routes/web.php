<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::redirect('/', '/projectManagers');
// Route::get('/', function () {
//     return route('projectManagers.index');
// });

Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    Route::redirect('/home', '/projectManagers');
    Route::resource('projectManagers', 'ProjectManagersController');
	Route::post('/jobs/addEmp', 'JobsController@addEmp');
	Route::post('/jobs/removeEmp', 'JobsController@removeEmp');
	Route::post('/jobs/getEmps', 'JobsController@getEmps');

    Route::post('/jobs', 'JobsController@AddEmployee');

    Route::resource('jobs', 'JobsController');
    Route::resource('accountants', 'AccountantsController');
    Route::resource('foremen', 'ForemenController');
    Route::resource('employees', 'EmployeesController');
    Route::resource('paygroups', 'PaygroupsController');
});

