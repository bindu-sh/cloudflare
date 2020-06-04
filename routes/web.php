<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/insertDns', 'HomeController@insertDNSRecords')->name('insertDns');
Route::get('/domains','HomeController@fetchDomains')->name('domains');
Route::get('/dnsRecords','HomeController@getDNSList')->name('dnsRecords');
Route::get('/deleteDns','HomeController@deleteDns')->name('deleteDns');
Route::get('/deleteZones','HomeController@deleteZones')->name('deleteZones');

