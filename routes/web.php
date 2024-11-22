<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContactMailController;

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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('{type}/certificate-download/{slug}/{user_id}', [CertificateController::class, 'download']);

Route::get('certificate-pdf', function () {
    return view('certificate');
})->name('certificate.index');

Route::get('/login/{provider}', [SocialiteController::class, 'redirectToProvider']);
Route::get('/login/{provider}/callback', [SocialiteController::class, 'handleProvideCallback']);

Route::get('contact-email', [ContactMailController::class, 'index']);
