<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HealthController;

// Health check routes (no auth required)
Route::get('/health', [HealthController::class, 'index'])->name('health');
Route::get('/health/detailed', [HealthController::class, 'detailed'])->name('health.detailed');

// Redirect root to login page
Route::get('/', function () {
    return redirect()->route('login');
});

// Redirect generic dashboard to role-specific dashboard
Route::get('/dashboard', function () {
    $user = auth()->user();
    
    return match($user->role) {
        'superadmin', 'admin_fakultas' => redirect()->route('admin.dashboard'),
        'dosen' => redirect()->route('dosen.dashboard'),
        'mahasiswa' => redirect()->route('mahasiswa.dashboard'),
        default => redirect()->route('login'),
    };
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Notifications
    Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/unread-count', [\App\Http\Controllers\NotificationController::class, 'unreadCount'])->name('notifications.unread-count');
    Route::post('/notifications/{notification}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('/notifications/mark-all-read', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
});


// --- DOSEN ROUTES ---
Route::middleware(['auth', 'role:dosen'])->prefix('dosen')->name('dosen.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [\App\Http\Controllers\Dosen\DashboardController::class, 'index'])->name('dashboard');

    // E-Learning (LMS)
    Route::get('/lms', [\App\Http\Controllers\Dosen\LmsController::class, 'index'])->name('lms.index');

    // Bimbingan (Dosen PA)
    Route::get('/bimbingan', [\App\Http\Controllers\Dosen\BimbinganController::class, 'index'])->name('bimbingan.index');
    Route::get('/bimbingan/krs-approval', [\App\Http\Controllers\Dosen\BimbinganController::class, 'krsApproval'])->name('bimbingan.krs-approval');
    Route::get('/bimbingan/krs/{krs}', [\App\Http\Controllers\Dosen\BimbinganController::class, 'showKrs'])->name('bimbingan.krs-show');
    Route::post('/bimbingan/krs/{krs}/approve', [\App\Http\Controllers\Dosen\BimbinganController::class, 'approveKrs'])->name('bimbingan.krs-approve');
    Route::post('/bimbingan/krs/{krs}/reject', [\App\Http\Controllers\Dosen\BimbinganController::class, 'rejectKrs'])->name('bimbingan.krs-reject');

    // Presensi
    Route::get('/presensi', [\App\Http\Controllers\Dosen\PresensiController::class, 'index'])->name('presensi.index');
    Route::get('/presensi/kelas/{kelas}', [\App\Http\Controllers\Dosen\PresensiController::class, 'showKelas'])->name('presensi.kelas');
    Route::get('/presensi/kelas/{kelas}/pertemuan/create', [\App\Http\Controllers\Dosen\PresensiController::class, 'createPertemuan'])->name('presensi.pertemuan.create');
    Route::post('/presensi/kelas/{kelas}/pertemuan', [\App\Http\Controllers\Dosen\PresensiController::class, 'storePertemuan'])->name('presensi.pertemuan.store');
    Route::get('/presensi/pertemuan/{pertemuan}/input', [\App\Http\Controllers\Dosen\PresensiController::class, 'inputPresensi'])->name('presensi.input');
    Route::post('/presensi/pertemuan/{pertemuan}', [\App\Http\Controllers\Dosen\PresensiController::class, 'storePresensi'])->name('presensi.store');

    // Skripsi Bimbingan
    Route::get('/skripsi', [\App\Http\Controllers\Dosen\SkripsiController::class, 'index'])->name('skripsi.index');
    Route::get('/skripsi/{skripsi}', [\App\Http\Controllers\Dosen\SkripsiController::class, 'show'])->name('skripsi.show');
    Route::post('/skripsi/bimbingan/{bimbingan}/review', [\App\Http\Controllers\Dosen\SkripsiController::class, 'reviewBimbingan'])->name('skripsi.bimbingan.review');
    Route::put('/skripsi/{skripsi}/status', [\App\Http\Controllers\Dosen\SkripsiController::class, 'updateStatus'])->name('skripsi.update-status');

    // KP Bimbingan
    Route::get('/kp', [\App\Http\Controllers\Dosen\KpController::class, 'index'])->name('kp.index');
    Route::get('/kp/{kp}', [\App\Http\Controllers\Dosen\KpController::class, 'show'])->name('kp.show');
    Route::post('/kp/logbook/{logbook}/review', [\App\Http\Controllers\Dosen\KpController::class, 'reviewLogbook'])->name('kp.logbook.review');
    Route::put('/kp/{kp}/status', [\App\Http\Controllers\Dosen\KpController::class, 'updateStatus'])->name('kp.update-status');

    // Kehadiran
    Route::get('/kehadiran', [\App\Http\Controllers\Dosen\KehadiranController::class, 'index'])->name('kehadiran.index');
    Route::post('/kehadiran', [\App\Http\Controllers\Dosen\KehadiranController::class, 'store'])->name('kehadiran.store');
    Route::post('/kehadiran/{kehadiran}/checkout', [\App\Http\Controllers\Dosen\KehadiranController::class, 'checkout'])->name('kehadiran.checkout');
    // Penilaian
    Route::get('/penilaian', [\App\Http\Controllers\Dosen\PenilaianController::class, 'index'])->name('penilaian.index');
    Route::get('/penilaian/{kelas}', [\App\Http\Controllers\Dosen\PenilaianController::class, 'show'])->name('penilaian.show');
    Route::post('/penilaian/{kelas}', [\App\Http\Controllers\Dosen\PenilaianController::class, 'store'])->middleware('throttle:penilaian')->name('penilaian.store');

    // Materi Kuliah
    Route::get('/materi/{kelas}', [\App\Http\Controllers\Dosen\MateriController::class, 'index'])->name('materi.index');
    Route::post('/materi/{kelas}', [\App\Http\Controllers\Dosen\MateriController::class, 'store'])->name('materi.store');
    Route::put('/materi/{kelas}/{materi}', [\App\Http\Controllers\Dosen\MateriController::class, 'update'])->name('materi.update');
    Route::delete('/materi/{kelas}/{materi}', [\App\Http\Controllers\Dosen\MateriController::class, 'destroy'])->name('materi.destroy');
    Route::get('/materi/{kelas}/download/{materi}', [\App\Http\Controllers\Dosen\MateriController::class, 'download'])->name('materi.download');

    // Tugas
    Route::get('/tugas/{kelas}', [\App\Http\Controllers\Dosen\TugasController::class, 'index'])->name('tugas.index');
    Route::post('/tugas/{kelas}', [\App\Http\Controllers\Dosen\TugasController::class, 'store'])->name('tugas.store');
    Route::get('/tugas/{kelas}/{tugas}', [\App\Http\Controllers\Dosen\TugasController::class, 'show'])->name('tugas.show');
    Route::post('/tugas/{kelas}/submission/{submission}/grade', [\App\Http\Controllers\Dosen\TugasController::class, 'grade'])->name('tugas.grade');
    Route::post('/tugas/{kelas}/{tugas}/toggle', [\App\Http\Controllers\Dosen\TugasController::class, 'toggle'])->name('tugas.toggle');
    Route::delete('/tugas/{kelas}/{tugas}', [\App\Http\Controllers\Dosen\TugasController::class, 'destroy'])->name('tugas.destroy');
    Route::get('/tugas/{kelas}/submission/{submission}/download', [\App\Http\Controllers\Dosen\TugasController::class, 'downloadSubmission'])->name('tugas.submission.download');
});

require __DIR__.'/auth.php';
require __DIR__.'/mahasiswa/index.php';
require __DIR__.'/admin/index.php';
