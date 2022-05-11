<?php

use App\Http\Controllers\SecretController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/secrets', 'SecretController@index');