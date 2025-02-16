<?php

use App\Http\Controllers\IssueController;
use Illuminate\Support\Facades\Route;

Route::controller(IssueController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/issue', 'show')->name('show');
});
