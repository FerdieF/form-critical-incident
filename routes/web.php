<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HrdController;

// Otomatis arahkan halaman depan ke login
Route::redirect('/', '/login');

// ==========================================================
// RUTE AUTENTIKASI (TIDAK PERLU LOGIN UNTUK AKSES INI)
// ==========================================================
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// ==========================================================
// RUTE WAJIB LOGIN (DIJAGA SATPAM MIDDLEWARE)
// ==========================================================
Route::middleware(['auth'])->group(function () {
    
    // --- DASHBOARD & PROFILE ---
    // Pintu masuk utama: kita arahkan sesuai ROLE user
    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('user.dashboard');
    })->name('dashboard');

    // Dashboard Admin (Memanggil fungsi indexAdmin di HrdController)
    Route::get('/admin/dashboard', [App\Http\Controllers\HrdController::class, 'indexAdmin'])
        ->name('admin.dashboard')
        ->middleware('auth'); // Pastikan login dulu

        // --- MENU KHUSUS ADMIN ---
    Route::get('/admin/tambah-peserta', [HrdController::class, 'createPeserta'])->name('admin.peserta.create');
    Route::post('/admin/tambah-peserta', [HrdController::class, 'storePeserta'])->name('admin.peserta.store');
    
    // Route untuk cetak PDF semua karyawan
    Route::get('/admin/cetak-semua-pdf', [HrdController::class, 'cetakSemuaPdf'])->name('admin.print_semua_pdf');

    // Route untuk cetak PDF individu (per karyawan)
    Route::get('/admin/cetak-pdf/{id}', [HrdController::class, 'cetakIndividuPdf'])->name('admin.print_individu_pdf');

    // Dashboard User (Rekap untuk peserta)
    Route::get('/user/dashboard', function () {
        $karyawan = auth()->user()->karyawan; 
        return view('pages.dashboard.user', [
            'title' => 'Dashboard Peserta',
            'karyawan' => $karyawan
        ]);
    })->name('user.dashboard')->middleware('auth');

    Route::get('/profile', function () {
        return view('pages.profile', ['title' => 'Profile']);
    })->name('profile');


    // --- MENU KHUSUS ADMIN ---
    Route::get('/data-karyawan', [HrdController::class, 'indexKaryawan'])->name('admin.karyawan.index');
    Route::get('/data-karyawan/{id}/detail', [HrdController::class, 'showKaryawan'])->name('admin.karyawan.show');
    Route::get('/data-critical-incident', [HrdController::class, 'indexCriticalIncident'])->name('admin.incident.index');

    


    // --- MENU FORM ASESMEN PESERTA ---
    Route::get('/form-karyawan', [HrdController::class, 'create'])->name('form.create');
    Route::post('/form-karyawan', [HrdController::class, 'store'])->name('form.store');

    Route::get('/form-keluarga', [HrdController::class, 'createKeluarga'])->name('form.keluarga');
    Route::post('/form-keluarga/store', [HrdController::class, 'storeKeluarga'])->name('form.keluarga.store');

    Route::get('/form-pendidikan', [HrdController::class, 'createPendidikan'])->name('form.pendidikan');
    Route::post('/form-pendidikan/store', [HrdController::class, 'storePendidikan'])->name('form.pendidikan.store');

    Route::get('/form-pekerjaan', [HrdController::class, 'createPekerjaan'])->name('form.pekerjaan');
    Route::post('/form-pekerjaan/store', [HrdController::class, 'storePekerjaan'])->name('form.pekerjaan.store');

    Route::get('/form-detail-pekerjaan', [HrdController::class, 'createDetailPekerjaan'])->name('form.detail_pekerjaan');
    Route::post('/form-detail-pekerjaan/store', [HrdController::class, 'storeDetailPekerjaan'])->name('form.detail_pekerjaan.store');

    Route::get('/form-kondisi-kerja', [HrdController::class, 'createKondisiKerja'])->name('form.kondisi_kerja');
    Route::post('/form-kondisi-kerja/store', [HrdController::class, 'storeKondisiKerja'])->name('form.kondisi_kerja.store');

    Route::get('/form-minat-harapan', [HrdController::class, 'createMinatHarapan'])->name('form.minat_harapan');
    Route::post('/form-minat-harapan/store', [HrdController::class, 'storeMinatHarapan'])->name('form.minat_harapan.store');

    Route::get('/form-kekuatan-kelemahan', [HrdController::class, 'createKekuatanKelemahan'])->name('form.kekuatan_kelemahan');
    Route::post('/form-kekuatan-kelemahan/store', [HrdController::class, 'storeKekuatanKelemahan'])->name('form.kekuatan_kelemahan.store');

    Route::get('/form-critical-incident', [HrdController::class, 'createCriticalIncident'])->name('form.critical_incident');
    Route::post('/form-critical-incident/store', [HrdController::class, 'storeCriticalIncident'])->name('form.critical_incident.store');

});

// Sisa rute template UI Elements (Charts, Buttons, dll) boleh kamu taruh di bawah sini jika masih mau dipakai untuk referensi desain. 
// Tapi sangat disarankan untuk DIBUANG saja jika tidak dipakai agar aplikasi tidak berat.
