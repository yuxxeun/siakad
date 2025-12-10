<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\FakultasController;
use App\Http\Controllers\Admin\ProdiController;
use App\Http\Controllers\Admin\MataKuliahController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\TahunAkademikController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KrsApprovalController;
use App\Http\Controllers\Admin\MahasiswaController;
use App\Http\Controllers\Admin\DosenController;
use App\Http\Controllers\Mahasiswa\KrsController;
use App\Http\Controllers\Mahasiswa\TranskripController;
use App\Http\Controllers\Dosen\PenilaianController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// --- ADMIN ROUTES ---
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Users
    Route::post('/users', [UserController::class, 'store'])->name('users.store');

    // Master Data - Fakultas
    Route::get('/fakultas', [FakultasController::class, 'index'])->name('fakultas.index');
    Route::post('/fakultas', [FakultasController::class, 'store'])->name('fakultas.store');
    Route::put('/fakultas/{fakultas}', [FakultasController::class, 'update'])->name('fakultas.update');
    Route::delete('/fakultas/{fakultas}', [FakultasController::class, 'destroy'])->name('fakultas.destroy');

    // Master Data - Prodi
    Route::get('/prodi', [ProdiController::class, 'index'])->name('prodi.index');
    Route::post('/prodi', [ProdiController::class, 'store'])->name('prodi.store');
    Route::put('/prodi/{prodi}', [ProdiController::class, 'update'])->name('prodi.update');
    Route::delete('/prodi/{prodi}', [ProdiController::class, 'destroy'])->name('prodi.destroy');

    // Master Data - Mata Kuliah
    Route::get('/mata-kuliah', [MataKuliahController::class, 'index'])->name('mata-kuliah.index');
    Route::post('/mata-kuliah', [MataKuliahController::class, 'store'])->name('mata-kuliah.store');
    Route::put('/mata-kuliah/{mataKuliah}', [MataKuliahController::class, 'update'])->name('mata-kuliah.update');
    Route::delete('/mata-kuliah/{mataKuliah}', [MataKuliahController::class, 'destroy'])->name('mata-kuliah.destroy');

    // Master Data - Kelas
    Route::get('/kelas', [KelasController::class, 'index'])->name('kelas.index');
    Route::post('/kelas', [KelasController::class, 'store'])->name('kelas.store');
    Route::put('/kelas/{kelas}', [KelasController::class, 'update'])->name('kelas.update');
    Route::delete('/kelas/{kelas}', [KelasController::class, 'destroy'])->name('kelas.destroy');

    Route::get('/tahun-akademik/active', [TahunAkademikController::class, 'getActive'])->name('tahun-akademik.active');
    Route::post('/tahun-akademik/{id}/activate', [TahunAkademikController::class, 'activate'])->name('tahun-akademik.activate');

    // KRS Approval
    Route::get('/krs-approval', [KrsApprovalController::class, 'index'])->name('krs-approval.index');
    Route::get('/krs-approval/{krs}', [KrsApprovalController::class, 'show'])->name('krs-approval.show');
    Route::post('/krs-approval/{krs}/approve', [KrsApprovalController::class, 'approve'])->name('krs-approval.approve');
    Route::post('/krs-approval/{krs}/reject', [KrsApprovalController::class, 'reject'])->name('krs-approval.reject');
    Route::post('/krs-approval/bulk-approve', [KrsApprovalController::class, 'bulkApprove'])->name('krs-approval.bulk-approve');

    // Mahasiswa Management
    Route::get('/mahasiswa', [MahasiswaController::class, 'index'])->name('mahasiswa.index');
    Route::get('/mahasiswa/{mahasiswa}', [MahasiswaController::class, 'show'])->name('mahasiswa.show');

    // Dosen Management
    Route::get('/dosen', [DosenController::class, 'index'])->name('dosen.index');
    Route::get('/dosen/{dosen}', [DosenController::class, 'show'])->name('dosen.show');
});

// --- MAHASISWA ROUTES ---
Route::middleware(['auth', 'role:mahasiswa'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [\App\Http\Controllers\Mahasiswa\DashboardController::class, 'index'])->name('dashboard');

    Route::get('/krs', [KrsController::class, 'index'])->name('krs.index');
    Route::post('/krs', [KrsController::class, 'store'])->name('krs.store');
    Route::delete('/krs/{detailId}', [KrsController::class, 'destroy'])->name('krs.destroy');
    Route::post('/krs/submit', [KrsController::class, 'submit'])->name('krs.submit');
    Route::post('/krs/revise', [KrsController::class, 'revise'])->name('krs.revise');
    
    // Transkrip
    Route::get('/transkrip', [TranskripController::class, 'index'])->name('transkrip.index');
    
    // Biodata
    Route::get('/biodata', [\App\Http\Controllers\Mahasiswa\BiodataController::class, 'index'])->name('biodata.index');
    Route::put('/biodata', [\App\Http\Controllers\Mahasiswa\BiodataController::class, 'update'])->name('biodata.update');
    Route::put('/biodata/password', [\App\Http\Controllers\Mahasiswa\BiodataController::class, 'updatePassword'])->name('biodata.password');
});

// --- DOSEN ROUTES ---
Route::middleware(['auth', 'role:dosen'])->prefix('dosen')->name('dosen.')->group(function () {
    Route::get('/penilaian', [PenilaianController::class, 'index'])->name('penilaian.index');
    Route::post('/penilaian', [PenilaianController::class, 'store'])->name('penilaian.store');

    // Bimbingan (Dosen PA)
    Route::get('/bimbingan', [\App\Http\Controllers\Dosen\BimbinganController::class, 'index'])->name('bimbingan.index');
    Route::get('/bimbingan/krs-approval', [\App\Http\Controllers\Dosen\BimbinganController::class, 'krsApproval'])->name('bimbingan.krs-approval');
    Route::get('/bimbingan/krs/{krs}', [\App\Http\Controllers\Dosen\BimbinganController::class, 'showKrs'])->name('bimbingan.krs-show');
    Route::post('/bimbingan/krs/{krs}/approve', [\App\Http\Controllers\Dosen\BimbinganController::class, 'approveKrs'])->name('bimbingan.krs-approve');
    Route::post('/bimbingan/krs/{krs}/reject', [\App\Http\Controllers\Dosen\BimbinganController::class, 'rejectKrs'])->name('bimbingan.krs-reject');
});

require __DIR__.'/auth.php';


