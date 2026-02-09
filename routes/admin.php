<?php

use App\Http\Middleware\AdminPanelMiddleware;
use Illuminate\Support\Facades\Route;


Route::get('/panel/admin/login', function () {
    return redirect('/admin/login');
})->name('panel.admin.login');
