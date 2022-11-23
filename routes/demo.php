<?php

use App\Http\Controllers\DemoController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => [
        'auth',
    ],
], function () {
    Route::get('/demos', [DemoController::class, 'index'])
        ->name('demos.index');

    Route::get('/demos/{folder}', [DemoController::class, 'fileList'])
        ->name('demos.file_list');

    Route::get('/demos/{folder}/{file}', [DemoController::class, 'fileDetails'])
        ->name('demos.file_details');
});
