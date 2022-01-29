<?php

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


use App\Http\Controllers\API\WebsiteController;
use Illuminate\Support\Facades\Route;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

/*Route::get('{any}', function() {
    QrCode::size(250)
        ->format('png')
        ->generate(url()->current(), public_path('images/qr-'. rand() .'.png'));

    return view('email.template');
})->where('any', '.*');*/

Route::get('send', function() {
    return view('email.custom');
});

Route::get('{any}', function() {
    return view('app');
})->where('any', '.*');
