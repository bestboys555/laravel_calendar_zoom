<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '','as'=>'web.'], function() {
    Route::get('', ['as' => 'home', 'uses' => 'WebpageController@index']);

    Route::get('meeting_your_list', ['as' => 'meeting_your_list', 'uses' => 'WebpageCoursecalendarController@meeting_your_list', 'middleware' => ['verified']]);
    Route::get('zoom_list', ['as' => 'zoom_list', 'uses' => 'WebpageCoursecalendarController@zoom_list', 'middleware' => ['verified']]);
    Route::get('calendar/{id}', ['as' => 'coursecalendar', 'uses' => 'WebpageCoursecalendarController@coursecalendar']);
    Route::get('educational-events/{id}', ['as' => 'coursecalendar_data', 'uses' => 'WebpageCoursecalendarController@coursecalendar_data']);
    Route::get('register_educational-events/{id}', ['as' => 'register_coursecalendar', 'uses' => 'WebpageCoursecalendarController@register_coursecalendar'])->middleware('verified');
    Route::get('register_educational-events_view/{id}', ['as' => 'register_coursecalendar_view', 'uses' => 'WebpageCoursecalendarController@register_coursecalendar_view'])->middleware('verified');
    Route::put('register_educational-events/{id}/confirm', ['as' => 'register_coursecalendar_confirm', 'uses' => 'WebpageCoursecalendarController@register_coursecalendar_confirm'])->middleware('verified');
    Route::put('register_educational-events/{id}/upload_payment', ['as' => 'register_upload_payment_coursecalendar', 'uses' => 'WebpageCoursecalendarController@register_upload_payment']);
    Route::get('get_events', ['as' => 'get_events', 'uses' => 'WebpageCoursecalendarController@get_events']);
    //
    Route::get('search/', ['as' => 'search', 'uses' => 'WebpageController@search']);

});
