<?php

use Illuminate\Support\Facades\Route;

require_once base_path('routes/api.php');

Route::get('/', function () {
    return view('welcome');
});
