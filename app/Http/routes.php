<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::auth();
Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');

Route::any('/users/status/{status}', 'Users\UsersController@byStatus');
Route::any('/users/program/{program}', 'Users\UsersController@byProgram');
Route::any('/users/trashed', 'Users\UsersController@trashed');
Route::any('/users/trashed/{option}/{id}', 'Users\UsersController@trashed');
Route::any('/users/import/{program}', 'Users\UsersController@import');
Route::any('/users/liquidate/{program}', 'Users\UsersController@liquidate');
Route::any('/users/processimport/{program}', 'Users\UsersController@processImport');
Route::any('/users/processliquidate/{challenge}/{period}', 'Users\UsersController@processLiquidate');
Route::any('/users/processvariables/{program}/{period}', 'Users\UsersController@processVariables');
Route::resource('users','Users\UsersController');
Route::get('user/agree/{program}', 'ProgramsController@agreeTerms');
Route::get('/users/{user}/challenges', 'Users\UsersController@challenges');
Route::get('/users/{user}/variables', 'Users\UsersController@variables');
Route::get('/users/{user}/goals', 'Users\UsersController@goals');

Route::any('/roles/program/{program}', 'Users\RolesController@byProgram');
Route::any('/roles/trashed', 'Users\RolesController@trashed');
Route::any('/roles/trashed/{option}/{id}', 'Users\RolesController@trashed');
Route::resource('roles','Users\RolesController');
Route::resource('permissions','Users\PermissionsController');
Route::resource('programs','ProgramsController');

Route::any('/challenges/program/{program}', 'Challenges\ChallengesController@byProgram');
Route::any('/challenges/trashed', 'Challenges\ChallengesController@trashed');
Route::any('/challenges/trashed/{option}/{id}', 'Challenges\ChallengesController@trashed');
Route::resource('challenges','Challenges\ChallengesController');

Route::any('/variables/program/{program}', 'Challenges\VariablesController@byProgram');
Route::any('/variables/trashed', 'Challenges\VariablesController@trashed');
Route::any('/variables/trashed/{option}/{id}', 'Challenges\VariablesController@trashed');
Route::any('/variables/type/{type}', 'Challenges\VariablesController@byType');
Route::resource('variables','Challenges\VariablesController');

Route::any('/goals/program/{program}', 'Challenges\GoalsController@byProgram');
Route::any('/goals/trashed', 'Challenges\GoalsController@trashed');
Route::any('/goals/trashed/{option}/{id}', 'Challenges\GoalsController@trashed');
Route::any('/goals/type/{type}', 'Challenges\GoalsController@byType');
Route::resource('goals','Challenges\GoalsController');

Route::resource('import_templates','Users\ImportTemplatesController');
Route::any('/import_templates/users/download', 'Users\ImportTemplatesController@usersdownload');
Route::any('/import_templates/{template}/download', 'Users\ImportTemplatesController@download');

Route::any('/search/users/{query}', 'Utils\SearchController@users');
Route::any('/search/variables/{query}', 'Utils\SearchController@variables');
Route::group(['prefix' => 'api'], function () {
    Route::get('users', 'Utils\ApiController@users');
    Route::get('roles', 'Utils\ApiController@roles');
    Route::get('programs', 'Utils\ApiController@programs');
    Route::get('challenges', 'Utils\ApiController@challenges');
    Route::get('channels', 'Utils\ApiController@channels');
});
Route::group(['prefix' => 'reports'], function () {
    Route::get('goals', 'Challenges\ReportsController@goals');
    Route::get('goals/export', 'Challenges\ReportsController@goalsexport');
});

Route::get('docs', function(){
    return \Illuminate\Support\Facades\View::make('docs.api.index');
});
