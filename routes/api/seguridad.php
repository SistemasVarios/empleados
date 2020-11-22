<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::name('passport_auth.token')->post('oauth/token', '\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken');
Route::name('seguridad.autenticacion_login')->post('autenticacion/login', 'seguridad\AutenticacionController@login');
Route::name('seguridad.autenticacion_logout')->post('autenticacion/logout', 'seguridad\AutenticacionController@logout');