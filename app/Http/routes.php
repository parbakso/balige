<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */

Route::get('/', ['as' => 'home', 'uses' => 'FrontController@index']);
Route::get('/lihatpoll', 'FrontController@polling');
Route::post('/tambahpoll', 'FrontController@tambahpoll');
Route::get('/berita', 'FrontController@beritalist');
Route::get('/berita/{id}', 'FrontController@berita');
Route::get('/pengumuman', 'FrontController@pengumumanlist');
Route::get('/pengumuman/{id}', 'FrontController@pengumuman');
Route::get('/agenda', 'FrontController@agendalist');
Route::get('/agenda/{id}', 'FrontController@agenda');
Route::get('/loker', 'FrontController@lokerlist');
Route::get('/loker/{id}', 'FrontController@loker');
Route::get('/inspiratif', 'FrontController@inspiratiflist');
Route::get('/inspiratif/{id}', 'FrontController@inspiratif');
Route::get('/galeri', 'FrontController@album');
Route::get('/download', 'FrontController@download');
Route::get('/galeri/{id}', 'FrontController@foto');
Route::get('/page/{id}', ['as' => 'page.menu', 'uses' => 'FrontController@halaman']);

Route::get('/login', ['middleware' => 'guest', function() {
return view('backend.login');
}]);
Route::post('/login', 'LoginController@auth');
Route::get('/logout', 'LoginController@logout');
Route::get('home', 'HomeController@index');

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function() {
    Route::get('/', function() {
        return view('backend.dashboard');
    });
    Route::get('/datadinamis', ['as' => 'admin.dashboard.datadinamis', function() {
    return view('backend.datadinamis');
}]);

    Route::get('/sekolah', ['as' => 'admin.dashboard.sekolah', function() {
    return view('backend.sekolah');
}]);
    Route::resource('datastatis', 'Admin\DataStatisController');
    Route::resource('berita', 'Admin\BeritaController');
    Route::resource('pengumuman', 'Admin\PengumumanController');
    Route::resource('agenda', 'Admin\AgendaController');
    Route::resource('loker', 'Admin\LokerController');
    Route::resource('inspiratif', 'Admin\InspiratifController');
    Route::resource('angkatan', 'Admin\AngkatanController');
    Route::resource('alumni', 'Admin\AlumniController');    
    Route::get('angkatan/{id}/alumni', 'Admin\AlumniController@listAlumniByAngkatan');
    Route::post('angkatan/{id}/alumni', 'Admin\AlumniController@storeAlumniByAngkatan');
    Route::get('angkatan/{id}/alumni/create', 'Admin\AlumniController@createAlumniByAngkatan');
    Route::resource('pegawai', 'Admin\PegawaiController');
    Route::resource('polling', 'Admin\PollingController');
    Route::resource('polling/{id}/jawaban', 'Admin\JawabanController');
    Route::resource('galeri', 'Admin\GaleriController');
    Route::resource('galeri/{id}/foto', 'Admin\FotoController');
    Route::resource('absensi', 'Admin\AbsensiController');
    Route::resource('upload', 'Admin\UploadController');
    Route::post('upload/update', 'Admin\UploadController@updateFile');
    Route::post('absensi/create', ['as' => 'admin.absensi.create', 'uses' => 'Admin\AbsensiController@create']);
    Route::post('absensi/show', ['as' => 'admin.absensi.show', 'uses' => 'Admin\AbsensiController@show']);
});

Route::group(['prefix' => 'guru','middleware' => 'auth'], function() {
    Route::get('/', function() {
        return view('guru.dashboard');
    });
    Route::resource('pengumuman', 'Admin\PengumumanController');
    Route::resource('upload', 'Admin\UploadController');
    Route::resource('absensi', 'Admin\AbsensiController');
    Route::get('pegawai/{id}', ['as' => 'guru.pegawai.edit', 'uses' => 'Admin\PegawaiController@edit']);
    Route::put('pegawai/{id}', ['as' => 'guru.pegawai.update', 'uses' => 'Admin\PegawaiController@update']);
    Route::post('absensi/create', ['as' => 'guru.absensi.create', 'uses' => 'Admin\AbsensiController@create']);
    Route::post('absensi/show', ['as' => 'guru.absensi.show', 'uses' => 'Admin\AbsensiController@show']);
});

Route::group(['prefix' => 'api'], function() {
    Route::get('datastatis', 'Admin\DataStatisController@apiDataStatis');
    Route::get('datastatis/{id}', 'Admin\DataStatisController@show');
    Route::get('menu', 'Admin\DataStatisController@apiCreateMenu');

    Route::get('berita', 'Admin\BeritaController@apiBerita');
    Route::get('berita/{id}', 'Admin\BeritaController@show');

    Route::get('pengumuman', 'Admin\PengumumanController@apiPengumuman');
    Route::get('pengumuman/{id}', 'Admin\PengumumanController@show');

    Route::get('agenda', 'Admin\AgendaController@apiAgenda');
    Route::get('agenda/{id}', 'Admin\AgendaController@show');

    Route::get('loker', 'Admin\LokerController@apiLoker');
    Route::get('loker/{id}', 'Admin\LokerController@show');

    Route::get('inspiratif', 'Admin\InspiratifController@apiInspiratif');
    Route::get('inspiratif/{id}', 'Admin\InspiratifController@show');

    Route::get('provinsi-list-dropdown', 'Admin\AlumniController@apiProvinsiList');

    Route::get('angkatan', 'Admin\AngkatanController@apiAngkatan');
    Route::get('angkatan/{id}', 'Admin\AngkatanController@show');

    Route::get('angkatan/{id}/alumni', 'Admin\AlumniController@apiAlumni');
    Route::get('alumni/{id}', 'Admin\AlumniController@show');
    Route::get('angkatandropdown', 'Admin\AngkatanController@apiCreateAngkatan');

    Route::get('pegawai', 'Admin\PegawaiController@apiPegawai');
    Route::get('pegawai/{id}', 'Admin\PegawaiController@show');

    Route::get('polling', 'Admin\PollingController@apiPolling');
    Route::get('polling/{id}', 'Admin\PollingController@show');
    Route::get('pollingdropdown', 'Admin\PollingController@apiCreatePolling');

    Route::get('polling/{id}/jawaban', 'Admin\JawabanController@apiJawaban');
    Route::get('jawaban/{id}', 'Admin\JawabanController@show');

    Route::get('galeri', 'Admin\GaleriController@apiGaleri');
    Route::get('galeri/{id}', 'Admin\GaleriController@show');
    Route::get('galeridropdown', 'Admin\GaleriController@apiCreateGaleri');

    Route::get('galeri/{id}/foto', 'Admin\FotoController@apiFoto');
    Route::get('foto/{id}', 'Admin\FotoController@show');

    Route::get('absensi', 'Admin\AbsensiController@apiAbsensi');
    Route::get('absensi/{id}', 'Admin\AbsensiController@apiAbsensi');

    Route::get('upload', 'Admin\UploadController@apiUpload');
    Route::get('upload/{id}', 'Admin\UploadController@apiUpload');

    Route::get('ambilalumni/{id}', 'FrontController@ambilsiswa');
    Route::post('showabsensi', 'FrontController@showabsensi');
});
