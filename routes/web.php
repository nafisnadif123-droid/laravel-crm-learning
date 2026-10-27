<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\MahasiswaController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/sapa', function () {
    return 'Selamat datang di Aplikasi Perpustakaan Kampus!';
});

Route::get('/tanggal', fn () => now()->translatedFormat('l, d F Y'));

Route::get('/info', fn () => [
    'aplikasi' => 'Perpustakaan Kampus',
    'versi' => '1.0',
    'framework' => 'Laravel 13',
]);

Route::get('/anggota/{nama}', function (string $nama) {
    return "Anggota perpustakaan: {$nama}";
});

Route::get('/rak/{genre?}', function (?string $genre = 'umum') {
    return "Menampilkan rak buku genre: {$genre}";
});

Route::get('/buku/{kategori}/tahun/{tahun}', function (string $kategori, int $tahun) {
    return "Buku kategori {$kategori} terbitan tahun {$tahun}";
});


Route::get('/peminjaman/{id}', function (int $id) {
    return "Detail peminjaman nomor {$id}";
})->whereNumber('id');

Route::get('/penulis/{nama}', function (string $nama) {
    return "Penulis: {$nama}";
})->whereAlpha('nama');

Route::get('/isbn/{isbn}', function (string $isbn) {
    return "ISBN: {$isbn}";
})->where('isbn', '[0-9]{13}');

Route::get('/status/{status}', function (string $status) {
    return "Status peminjaman: {$status}";
})->whereIn('status', ['dipinjam', 'dikembalikan', 'terlambat']);

Route::view('/layanan', 'layanan')->name('layanan');

Route::get('/bantuan', function () {
    return view('bantuan', ['telepon' => '(024) 1234567']);
})->name('bantuan');

Route::prefix('petugas')->name('petugas.')->group(function () {
    Route::get('/beranda', fn () => 'Beranda Petugas')->name('beranda');
    Route::get('/laporan', fn () => 'Laporan Peminjaman')->name('laporan');
    
    Route::get('/anggota/{id}', fn ($id) => "Detail Anggota Petugas ID: {$id}")->name('anggota');
});

Route::redirect('/home', '/');

Route::permanentRedirect('/katalog-lama', '/info');

Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
Route::get('/produk/{id}', [ProdukController::class, 'show'])->name('produk.show');


Route::get('/products', [ProductsController::class, 'index']);
/*Route::get('/products/{id}',function ($id) {
    return 'Produk #' . $id;
});*/

Route::get('/products/{id}', [ProductsController::class, 'show']);

Route::get('/profil', [MahasiswaController::class, 'profil'])->name('mahasiswa.profil');

Route::get('/mahasiswa', [MahasiswaController::class, 'daftar'])->name('mahasiswa.index');

Route::get('/mahasiswa/{nim}', [MahasiswaController::class, 'detail'])->name('mahasiswa.detail');

Route::fallback(function () {
    return response('Maaf, halaman yang Anda cari tidak tersedia.', 404);
});