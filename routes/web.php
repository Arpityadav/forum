<?php

Route::get('/', function () {
    return view('welcome');
});

Route::post('/threads', 'ThreadsController@store');

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::get('threads', 'ThreadsController@index');
Route::get('/threads/create', 'ThreadsController@create');
Route::get('/threads/{channel}', 'ThreadsController@index');
Route::get('threads/{channel}/{thread}', 'ThreadsController@show');
Route::delete('threads/{channel}/{thread}', 'ThreadsController@destroy');

Route::post('/threads/{channel}/{thread}/replies', 'RepliesController@store');
Route::get('/threads/{channel}/{thread}/replies', 'RepliesController@index');
Route::get('/threads/{channel}/{thread}/replies', 'RepliesController@index');
Route::delete('replies/{reply}', 'RepliesController@destroy');
Route::patch('replies/{reply}', 'RepliesController@update');

Route::post('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionController@store')->middleware('auth');
Route::delete('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionController@destroy')->middleware('auth');

Route::post('/replies/{reply}/favorites', 'FavoritesController@store');
Route::delete('/replies/{reply}/favorites', 'FavoritesController@destroy');

Route::get('profiles/{user}', 'ProfilesController@show');

Route::delete('profiles/{user}/notifications/{notification}', 'UserNotificationsController@destroy');
Route::get('profiles/{user}/notifications/', 'UserNotificationsController@index');
