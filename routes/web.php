<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/ 

Route::group(['namespace' => 'App\Http\Controllers'], function()
{  
    // Route::get('/', function () {
    //     return redirect('/commingsoon');
        
    //     // return redirect()->intended('/');
    // });
    // Route::get('/commingsoon', 'HomeController@commingsoon')->name('home.commingsoon');
    Route::get('/', 'HomeController@index')->name('home.index');
    Route::get('/about', 'HomeController@about')->name('home.about');

    Route::get('/contact', 'HomeController@contact')->name('home.contact');
    Route::post('/contact', 'HomeController@contactform')->name('home.contactform');

    Route::get('/assetmanagement', 'HomeController@assetmanagement')->name('home.assetmanagement');
    Route::get('/principalconsulting', 'HomeController@principalconsulting')->name('home.principalconsulting');
    Route::get('/greenrealty', 'HomeController@greenrealty')->name('home.greenrealty');
    Route::get('/article', 'HomeController@article')->name('home.article');

    Route::get('/whistle-blower', 'HomeController@whistle')->name('home.whistle');
    Route::get('/legal', 'HomeController@legal')->name('home.legal');
    Route::get('/privacy', 'HomeController@privacy')->name('home.privacy');

    Route::get('/welcome', 'HomeController@welcome')->name('home.welcome');
    Route::get('/inflation', 'HomeController@inflation')->name('home.welcome');
    Route::get('/shifting', 'HomeController@shifting')->name('home.shifting');

    Route::get('/februaryreport', 'HomeController@februaryreport')->name('home.februaryreport');


});
