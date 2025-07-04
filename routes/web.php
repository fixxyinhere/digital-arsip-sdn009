<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/backup/download/{path}', function ($path) {
    if (!auth()->user()->can('manage_backup')) {
        abort(403);
    }

    return Storage::download('backups/' . $path);
})->name('backup.download')->middleware('auth');