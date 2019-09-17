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

Route::get('/', function () {
    return view('home');
});

Route::get('/petugas','PetugasController@index');
Route::post('/petugas-store','PetugasController@store');
Route::get('/petugas/{id}/edit','PetugasController@edit');
Route::delete('/petugas-destroy/{id}','PetugasController@destroy');

Route::get('anggota','AnggotaController@index');
Route::post('anggota-store','AnggotaController@store');
Route::get('/anggota/{id}/edit','AnggotaController@edit');
Route::delete('/anggota-destroy/{id}','AnggotaController@destroy');

Route::get('buku','BukuController@index');
Route::post('buku-store','BukuController@store');
Route::get('/buku/{id}/edit','BukuController@edit');
Route::delete('/buku-destroy/{id}','BukuController@destroy');

Route::get('rak','RakController@index');
Route::post('rak-store','RakController@store');
Route::get('/rak/{id}/edit','RakController@edit');
Route::delete('/rak-destroy/{id}','RakController@destroy');

Route::get('/peminjaman','PeminjamanController@index');
Route::post('/peminjaman-store','PeminjamanController@store');
Route::get('peminjaman-isi/{id}','PengembalianController@isi');
Route::get('/peminjaman/{id}/edit','PeminjamanController@edit');
Route::delete('/peminjaman-destroy/{id}','PeminjamanController@destroy');

Route::get('pengembalian','PengembalianController@index');
Route::get('pengembalian-isi/{id}','PengembalianController@isi');
Route::post('pengembalian-store','PengembalianController@store');
Route::get('/pengembalian/{id}/edit','PengembalianController@edit');
Route::delete('/pengembalian-destroy/{id}','PengembalianController@destroy');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
