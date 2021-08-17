<?php
use Illuminate\Support\Facades\Route;

// Route::get('greeting', function () {
//     return 'Hi, this is your awesome package! rwra';
// });

// Route::get('Rwra/test', 'EdgeWizz\Rwra\Controllers\RwraController@test')->name('test');

Route::post('fmt/rwra/store', 'EdgeWizz\Rwra\Controllers\RwraController@store')->name('fmt.rwra.store');
Route::post('fmt/rwra/update/{id}', 'EdgeWizz\Rwra\Controllers\RwraController@update')->name('fmt.rwra.update');

Route::post('fmt/rwra/csv', 'EdgeWizz\Rwra\Controllers\RwraController@csv_upload')->name('fmt.rwra.csv');

Route::any('fmt/rwra/inactive/{id}',  'EdgeWizz\Rwra\Controllers\RwraController@inactive')->name('fmt.rwra.inactive');
Route::any('fmt/rwra/active/{id}',  'EdgeWizz\Rwra\Controllers\RwraController@active')->name('fmt.rwra.active');
