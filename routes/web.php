<?php

use App\Models\Karyawan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SpvController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\JudulController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\LemburController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\DepartmenController;

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

Route::get('/',[LaporanController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/dashboard', [LaporanController::class, 'index'])->name('dashboard');
        //create profile
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        //lembur
        Route::get('/lembur', [LaporanController::class, 'index'])->name('lembur');
        Route::get('/lembur/detail/{id}', [LaporanController::class, 'detail'])->name('lembur-detail');

        //karyawan
        Route::get('/karyawan', [KaryawanController::class, 'index'])->name('karyawan');
        Route::get('/buat-karyawan', [KaryawanController::class, 'create'])->name('buat-karyawan');
        Route::post('/tambah-karyawan', [KaryawanController::class, 'store'])->name('tambah-karyawan');
        Route::get('/karyawan/edit/{id}', [KaryawanController::class, 'edit'])->name('edit-karyawan');
        Route::patch('/karyawan/update/{id}', [KaryawanController::class, 'update'])->name('update-karyawan');
        Route::delete('/karyawan/delete/{id}', [KaryawanController::class, 'destroy'])->name('delete-karyawan');

        //kategori
        Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori');
        Route::get('/buat-kategori', [KategoriController::class, 'create'])->name('buat-kategori');
        Route::post('/tambah-kategori', [KategoriController::class, 'store'])->name('tambah-kategori');
        Route::get('/kategori/edit/{id}', [KategoriController::class, 'edit'])->name('edit-kategori');
        Route::put('/kategori/update/{id}', [KategoriController::class, 'update'])->name('update-kategori');
        Route::delete('/kategori/delete/{id}', [KategoriController::class, 'destroy'])->name('delete-kategori');

        //laporan
        Route::get('/laporan', [LemburController::class, 'lembur'])->name('laporan');
        Route::get('/buat-laporan', [LemburController::class, 'create'])->name('buat-laporan');
        Route::post('/tambah-laporan', [LemburController::class, 'store'])->name('tambah-laporan');
        Route::get('/laporan/edit/{id}', [LemburController::class, 'edit'])->name('edit-laporan');
        Route::put('/laporan/update/{id}', [LemburController::class, 'update'])->name('update-laporan');
        Route::delete('/laporan/delete/{id}', [LemburController::class, 'destroy'])->name('delete-laporan');

        //judul
        Route::get('/judul', [JudulController::class, 'index'])->name('judul');
        Route::get('/buat-judul', [JudulController::class, 'create'])->name('buat-judul');
        Route::post('/tambah-judul', [JudulController::class, 'store'])->name('tambah-judul');
        Route::get('/judul/edit/{id}', [JudulController::class, 'edit'])->name('edit-judul');
        Route::put('/judul/update/{id}', [JudulController::class, 'update'])->name('update-judul');
        Route::delete('/judul/delete/{id}', [JudulController::class, 'destroy'])->name('delete-judul');

        // datatables
        Route::get('/table_kategori',[KategoriController::class, 'datatable_kategori'])->name('table_kategori');
        Route::get('/table_karyawan',[KaryawanController::class, 'datatable_karyawan'])->name('table_karyawan');
        Route::get('/table_laporan',[LemburController::class, 'datatable_laporan'])->name('table_laporan');
        Route::get('/table_lembur',[LaporanController::class, 'datatable_lembur'])->name('table_lembur');
        Route::get('/table_lemburs',[LaporanController::class, 'datatable_lemburs'])->name('table_lemburs');
        Route::get('/table_judul',[JudulController::class, 'datatable_judul'])->name('table_judul');

        //export
        Route::get('/export-laporan/{id}', [ExportController::class, 'export'])->name('export-laporan');

});

require __DIR__.'/auth.php';
