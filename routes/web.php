<?php

Route::get('/', function () {
    return view('welcome');
});


Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');

Route::get('threads', 'ThreadsController@index');
Route::get('/threads/create', 'ThreadsController@create');
Route::post('/threads', 'ThreadsController@store')->middleware('verified')->name('threads');
Route::get('/threads/{channel}', 'ThreadsController@index');
Route::get('threads/{channel}/{thread}', 'ThreadsController@show');
Route::delete('threads/{channel}/{thread}', 'ThreadsController@destroy');
Route::patch('threads/{channel}/{thread}', 'ThreadsController@update');

Route::post('replies/{reply}/best-reply', 'BestRepliesController@store')->name('best-reply.store');

Route::post('lock-thread/{thread}', 'LockThreadsController@store')->name('lock-threads.store')->middleware('admin');
Route::delete('lock-thread/{thread}', 'LockThreadsController@destroy')->name('lock-threads.destroy')->middleware('admin');

Route::post('/threads/{channel}/{thread}/replies', 'RepliesController@store');
Route::get('/threads/{channel}/{thread}/replies', 'RepliesController@index');
Route::delete('replies/{reply}', 'RepliesController@destroy')->name('replies.destroy');
Route::patch('replies/{reply}', 'RepliesController@update');

Route::post('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionController@store')->middleware('auth');
Route::delete('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionController@destroy')->middleware('auth');

Route::post('/replies/{reply}/favorites', 'FavoritesController@store');
Route::delete('/replies/{reply}/favorites', 'FavoritesController@destroy');

Route::get('profiles/{user}', 'ProfilesController@show');

Route::delete('profiles/{user}/notifications/{notification}', 'UserNotificationsController@destroy');
Route::get('profiles/{user}/notifications/', 'UserNotificationsController@index');


Route::get('/api/users', 'Api\UsersController@index');
Route::post('/api/users/{user}/avatar', 'Api\UserAvatarController@store')->name('avatar');
