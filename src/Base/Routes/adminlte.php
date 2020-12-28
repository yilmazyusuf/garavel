<?php

/*
|--------------------------------------------------------------------------
| Admin Lte Default Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['web', 'auth']], function(){
    Route::get('/', 'Garavel\Controller\GaravelHomeController@index')->name('home');
    Route::resource('/users', 'Garavel\Controller\GaravelUserController');
    Route::get('/users/index/data_table', 'Garavel\Controller\GaravelUserController@indexDataTable')->name('users.index.data_table');

    Route::resource('/roles', 'Garavel\Controller\GaravelRoleController');
    Route::get('/roles/index/data_table', 'Garavel\Controller\GaravelRoleController@indexDataTable')->name('roles.index.data_table');

    Route::resource('/permissions', 'Garavel\Controller\GaravelPermissionController');
    Route::get('/permissions/index/data_table', 'Garavel\Controller\GaravelPermissionController@indexDataTable')->name('permissions.index.data_table');

    Route::resource('/menus', 'Garavel\Controller\GaravelMenuController');
    Route::resource('/settings', 'Garavel\Controller\GaravelSettingController');
    Route::get('/settings/index/data_table', 'Garavel\Controller\GaravelSettingController@indexDataTable')->name('settings.index.data_table');
    Route::post('/croppie', 'Garavel\Controller\GaravelCroppieController@upload')->name('croppie.upload');

});




