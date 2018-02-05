<?php

// Settings
Route::get('settings/commenting', 'CommentingSettingController@index')->name('settings.commenting');
Route::post('settings/commenting', 'CommentingSettingController@store')->name('settings.commenting.store');

// Route::get('comments/trash', '\Comment\Controllers\CommentController@trash')->name('comments.trash');
Route::post('comments/{id}/restore', '\Comment\Controllers\CommentController@restore')->name('comments.restore');
Route::get('comments/{delete}/delete', '\Comment\Controllers\CommentController@delete')->name('comments.delete');

Route::resource('comments', '\Comment\Controllers\CommentController');
// Route::resource('posts', 'Post\Controllers\PostController');
