<?php

include_file(core_path('routes'), 'fuzzy.php');

Route::get('/', 'Pluma\Support\Installation\Controllers\InstallController@welcome');

Route::get('welcome', '\Pluma\Support\Installation\Controllers\InstallController@welcome')->name("installation.welcome");

Route::get('welcome/next', '\Pluma\Support\Installation\Controllers\InstallController@next')->name("installation.next");

Route::post('welcome/write', '\Pluma\Support\Installation\Controllers\InstallController@write')->name("installation.write");

Route::get('welcome/install', '\Pluma\Support\Installation\Controllers\InstallController@show')->name("installation.show");

Route::post('welcome/install', '\Pluma\Support\Installation\Controllers\InstallController@install')->name("installation.install");

Route::get('welcome/last', '\Pluma\Support\Installation\Controllers\InstallController@last')->name("installation.last");

Route::post('welcome/migrate', '\Pluma\Support\Installation\Controllers\InstallController@migrate')->name("installation.migrate");

Route::get('{slug?}', 'Pluma\Support\Installation\Controllers\InstallController@welcome');
