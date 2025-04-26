<?php

use App\Http\Controllers\MobilController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

// Route::get('/', function () {
//     return view('cek');
// });

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();

Route::get('/', 'App\Http\Controllers\HomeController@index')->name('home')->middleware('auth');
Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home')->middleware('auth');

Route::group(['middleware' => 'auth'], function () {
		Route::get('icons', ['as' => 'pages.icons', 'uses' => 'App\Http\Controllers\PageController@icons']);
		Route::get('maps', ['as' => 'pages.maps', 'uses' => 'App\Http\Controllers\PageController@maps']);
		Route::get('notifications', ['as' => 'pages.notifications', 'uses' => 'App\Http\Controllers\PageController@notifications']);
		Route::get('rtl', ['as' => 'pages.rtl', 'uses' => 'App\Http\Controllers\PageController@rtl']);
		Route::get('tables', ['as' => 'pages.tables', 'uses' => 'App\Http\Controllers\PageController@tables']);
		Route::get('typography', ['as' => 'pages.typography', 'uses' => 'App\Http\Controllers\PageController@typography']);
		Route::get('upgrade', ['as' => 'pages.upgrade', 'uses' => 'App\Http\Controllers\PageController@upgrade']);
});

Route::group(['middleware' => 'auth'], function () {
	

	//user
	Route::group(['prefix' => 'user_management'], function () {
		Route::get('', [UserController::class, 'index'])->name('User.index');
		Route::post('load_data', [UserController::class, 'loadData'])->name('user.load_data');
		Route::get('/tambah', [UserController::class, 'tambah'])->name('User.create');
		Route::get('/show/{id?}', [UserController::class, 'show'])->name('user.show');
		Route::get('edit/{id}', [UserController::class, 'edit'])->name('user.edit');
		Route::post('simpan', [UserController::class, 'simpan'])->name('user.simpan');
		Route::post('simpanEdit', [UserController::class, 'simpanEdit'])->name('user.simpanEdit');
		Route::post('destroy', [UserController::class, 'destroy'])->name('user.hapus');
	});
	
	
	Route::group(['prefix' => 'mobil_management'], function () {
		Route::get('', [MobilController::class, 'index'])->name('mobil.index');
		Route::post('load_data', [MobilController::class, 'loadData'])->name('mobil.load_data');
		Route::get('/tambah', [MobilController::class, 'tambah'])->name('mobil.create');
		Route::get('/show/{id?}', [MobilController::class, 'show'])->name('mobil.show');
		Route::get('edit/{id}', [MobilController::class, 'edit'])->name('mobil.edit');
		Route::post('simpan', [MobilController::class, 'simpan'])->name('mobil.simpan');
		Route::post('simpanEdit', [MobilController::class, 'simpanEdit'])->name('mobil.simpanEdit');
		Route::post('destroy', [MobilController::class, 'destroy'])->name('mobil.hapus');
	});

	Route::group(['prefix' => 'pemesanan'], function () {
		Route::get('', [PemesananController::class, 'index'])->name('pemesanan.index');
		Route::post('load_data', [PemesananController::class, 'loadData'])->name('pemesanan.load_data');
		Route::get('/tambah', [PemesananController::class, 'tambah'])->name('pemesanan.create');
		Route::post('getMobil', [PemesananController::class, 'getMobil'])->name('pemesanan.getMobil');

		Route::get('/show/{id?}', [MobilController::class, 'show'])->name('mobil.show');
		Route::get('edit/{id}', [MobilController::class, 'edit'])->name('mobil.edit');
		Route::post('simpan', [PemesananController::class, 'simpan'])->name('sewa.simpan');
		Route::post('simpanEdit', [UserController::class, 'simpanEdit'])->name('user.simpanEdit');
	});
	









	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});

