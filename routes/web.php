<?php
use \Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
$router->get('/', function () use ($router) {
    return $router->app->version();
});
$router->post('/login', 'UserController@login');
$router->post('/register','UserController@register');
$router->get('/rapatDownloadFilePendukung/{idNotulen}/{namaFile}/{extension}', 'TransaksiController@downloadFilePendukung');
$router->get('/permohonanDownloadFileTransaksi/{idTransaksi}/{namaFile}/{extension}', 'TransaksiController@downloadFileTransaksi');

$router->group(['middleware' => 'jwt.auth'], function () use ($router) {
    $router->get('/home', 'HomeController@index');
    $router->post('/logout', 'UserController@logout');
    $router->post('/profile', 'UserController@getProfile');
    $router->post('/ruangan', 'RuangrapatController@getRuangan');
    $router->post('/ruanganDetail', 'RuangrapatController@detailRuangan');
    $router->post('/notulen', 'NotulenController@getNotulen');
    $router->post('/SKPD', 'MasterDataController@getSKPD');
    $router->post('/pegawai', 'MasterDataController@getPegawai');
    $router->post('/pegawaiPage', 'MasterDataController@getPegawaiPage');
    $router->post('/SKPDPage', 'MasterDataController@getSKPDPage');
    $router->post('/ruanganTambah', 'RuangrapatController@Store');
    $router->post('/ruanganPinjam', 'TransaksiController@store');
    $router->post('/ruanganEdit', 'RuangrapatController@Update');
    $router->post('/ruanganHapus', 'RuangrapatController@Destroy');
    $router->post('/rapat', 'TransaksiController@getAll');
    $router->post('rapatOpd', 'TransaksiController@getRapatOpd');
    $router->post('/rapatDetail', 'TransaksiController@detailRapat');
    $router->post('/permohonan', 'TransaksiController@getAll');
    $router->post('/permohonanDetail', 'TransaksiController@detailPermohonan');
    $router->post('/permohonanEdit', 'TransaksiController@Update');
    // $router->post('/permohonanDownloadFileTransaksi', 'TransaksiController@downloadFileTransaksi');
    $router->post('/pegawaiDetail', 'PegawaiController@detailPegawai');
    $router->post('/skpdStore', 'MasterDataController@StoreSKPD');
    $router->post('/detailtransaksi', 'TransaksiController@getDetailTransaksi');
    $router->post('/rapatTambahFilePendukung', 'TransaksiController@tambahFilePendukung');
    $router->post('/rapatTambahPeserta', 'TransaksiController@tambahPeserta');
    $router->post('/rapatEditDetail', 'TransaksiController@editDetailRapat');
    $router->post('rapatHapusAcara', 'TransaksiController@hapusAcara');
    $router->post('rapatHapusKegiatan', 'TransaksiController@hapusKegiatan');

    // $router->post('/rapatDownloadFilePendukung', 'TransaksiController@downloadFilePendukung');
});