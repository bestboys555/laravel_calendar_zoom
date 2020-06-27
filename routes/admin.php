<?php

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes(['verify' => true]);
Route::middleware('verified')->group(function () {
    Route::prefix('management')->group(function () {
        Route::get('', ['as' => 'admin_home', 'uses' => 'HomeController@index']);
        Route::resource('roles','RoleController');
        Route::resource('users','UserController');
        Route::group(['prefix' => 'users','as'=>'users.'], function() {
            Route::post('search', ['as' => 'search', 'uses' => 'UserController@search']);
            Route::get('export/excel', ['as' => 'export_excel', 'uses' => 'UserController@export_excel']);
        });
        Route::resource('media','MediaController');
        Route::group(['prefix' => 'media','as'=>'media.'], function() {
            Route::get('destroy/{id}', ['as' => 'destroy', 'uses' => 'MediaController@destroy']);
        });
        Route::resource('perm','PermController');
        Route::resource('category_news','News_categoryController');

        Route::group(['prefix' => 'settings/','as' => 'settings.'], function () {
            Route::get('general', ['as' => 'general', 'uses' => 'GeneralSettingController@general']);
            Route::put('general/{id}/update', ['as' => 'general.update',  'uses' => 'GeneralSettingController@update_general']);
            Route::get('zoom', ['as' => 'zoom', 'uses' => 'GeneralSettingController@zoom']);
            Route::put('zoom/{id}/update', ['as' => 'zoom.update',  'uses' => 'GeneralSettingController@update_zoom']);
        });

        Route::resource('coursecalendar','CoursecalendarController');
        Route::get('coursecalendar_payment_notification', ['as' => 'payment_coursecalendar_notification', 'uses' => 'CoursecalendarController@payment_notification']);
        Route::group(['prefix' => 'coursecalendar','as'=>'coursecalendar.'], function() {
            Route::post('search', ['as' => 'search', 'uses' => 'CoursecalendarController@search']);
            Route::get('show_payment/{id}', ['as' => 'show_payment', 'uses' => 'CoursecalendarController@show_payment']);// list user submit
            Route::get('export_excel/{id}', ['as' => 'export_excel', 'uses' => 'CoursecalendarController@export_excel']);// list user submit
            Route::get('destroy_register/{id}', ['as' => 'destroy_register', 'uses' => 'CoursecalendarController@destroy_register']);//del user submit
            Route::get('register_coursecalendar_view/{id}/{back}', ['as' => 'register_coursecalendar_view', 'uses' => 'CoursecalendarController@register_coursecalendar_view']);
            Route::put('show_payment/{id}/checkpayment', ['as' => 'register_checkpayment', 'uses' => 'CoursecalendarController@register_checkpayment']);// confirm_coursecalendar
        });

        Route::group(['prefix' => 'file','as'=>'file.'], function() {
            Route::post('upload_file', ['as' => 'upload_file', 'uses' => 'UploadfileController@upload_file']);
            Route::post('show_file', ['as' => 'show_file', 'uses' => 'UploadfileController@show_file']);
            Route::post('file_sortable', ['as' => 'file_sortable', 'uses' => 'UploadfileController@file_sortable']);
            Route::post('delete_file', ['as' => 'delete_file', 'uses' => 'UploadfileController@delete_file']);
            Route::post('setcover', ['as' => 'setcover', 'uses' => 'UploadfileController@setcover']);
        });

        Route::group(['prefix' => 'profile','as'=>'profile.'], function() {
            Route::get('data', ['as' => 'data', 'uses' => 'ProfileController@data']);
            Route::get('data_pass', ['as' => 'data_pass', 'uses' => 'ProfileController@data_pass']);
            Route::put('updateAuthUser', ['as' => 'updateAuthUser', 'uses' => 'ProfileController@updateAuthUser']);
            Route::put('UpdatePass', ['as' => 'UpdatePass', 'uses' => 'ProfileController@UpdatePass']);
            Route::post('Updatehidden_menu', ['as' => 'Updatehidden_menu', 'uses' => 'ProfileController@Updatehidden_menu']);
            Route::post('uploadAvatar', ['as' => 'uploadAvatar', 'uses' => 'ProfileController@uploadAvatar']);
        });
    });
});
