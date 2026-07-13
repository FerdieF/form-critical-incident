<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Karyawan; 
use App\Models\Keluarga; 
use App\Models\DetailPekerjaan;
use App\Models\Bawahan;
use App\Models\Pendidikan;
use App\Models\PengalamanKerja;
use App\Models\KondisiKerja;
use App\Models\MinatHarapan;
use App\Models\UsahaAspirasi;
use App\Models\KekuatanKelemahan;
use App\Models\CriticalIncident;
use Barryvdh\DomPDF\Facade\Pdf;

class HrdController extends Controller
{
    // =========================================================================
    // HELPER: Cek apakah user sudah mengisi identitas diri
    // =========================================================================
    private function getKaryawan()
    {
        return auth()->user()->karyawan;
    }

    // =========================================================================
    // TAHAP 1: IDENTITAS DIRI
    // =========================================================================
    public function create()
    {
        $karyawan = $this->getKaryawan();
        return view('pages.form.form', compact('karyawan')); // Sesuaikan nama view-mu
    }

    /**
     * Menyimpan atau memperbarui data identitas diri karyawan (Tahap 1).
     *
     * Initial state : Form identitas diri telah divalidasi dari request.
     * Final state   : Data karyawan tersimpan/terupdate di tabel `karyawans`,
     *                  lalu user diarahkan ke form susunan keluarga (Tahap 2).
     *
     * @author  Ferdi Akbar Nasution
     * @version 1.0 - 2026-07-13
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required',
            // Hapus validasi unique agar form bisa di-edit ulang tanpa error
        ]);

        $data = $request->all();
        $data['nik_sap'] = auth()->user()->nik_sap; // Otomatis ambil NIK SAP user

        // Gunakan updateOrCreate biar kalau ngedit data nggak double
        $karyawan = Karyawan::updateOrCreate(
            ['nik_sap' => auth()->user()->nik_sap],
            $data
        );

        return redirect()->route('form.keluarga')
                         ->with('success', 'Identitas Diri Berhasil Disimpan!');
    }

    // =========================================================================
    // TAHAP 2: SUSUNAN KELUARGA
    // =========================================================================
    public function createKeluarga() 
    {
        $karyawan = $this->getKaryawan();
        if (!$karyawan) return redirect()->route('form.create')->withErrors('Isi Identitas Diri terlebih dahulu!');

        return view('pages.form.keluarga', compact('karyawan'));
    }

    public function storeKeluarga(Request $request)
    {
        $karyawan = auth()->user()->karyawan;

        if (!$karyawan) {
            return redirect()->back()->withErrors('Data Identitas Diri belum diisi.');
        }

        // --- TAMBAHKAN BLOK VALIDASI INI ---
        // Cek jika status karyawan adalah "Belum Kawin"
        if ($karyawan->status_pernikahan === 'Belum Kawin' && $request->has('keluarga')) {
            foreach ($request->keluarga as $kel) {
                // Kita cek apakah inputan hubungannya mengandung kata Istri atau Suami
                $hubungan = strtolower($kel['hubungan'] ?? '');
                
                if (str_contains($hubungan, 'istri') || str_contains($hubungan, 'suami')) {
                    // Tendang kembali ke halaman form dengan pesan error
                    return redirect()->back()->withErrors('Status Anda saat ini "Belum Kawin". Anda tidak dapat menambahkan data Istri/Suami. Silakan perbarui Identitas Diri Anda terlebih dahulu jika status sudah berubah.')->withInput();
                }
            }
        }
        // --- AKHIR BLOK VALIDASI ---

        // Hapus data lama untuk mencegah duplikat saat edit
        \App\Models\Keluarga::where('karyawan_id', $karyawan->id)->delete();

        // Lanjut proses simpan seperti biasa...
        if ($request->has('keluarga')) {
            foreach ($request->keluarga as $kel) {
                if (!empty($kel['nama'])) {
                    \App\Models\Keluarga::create([
                        'karyawan_id'   => $karyawan->id,
                        'hubungan'      => $kel['hubungan'] ?? null,
                        'nama'          => $kel['nama'],
                        'jenis_kelamin' => $kel['jenis_kelamin'] ?? null,
                        'tempat_lahir'  => $kel['tempat_lahir'] ?? null,
                        'tanggal_lahir' => $kel['tanggal_lahir'] ?? null,
                        'pendidikan'    => $kel['pendidikan'] ?? null,
                        'pekerjaan'     => $kel['pekerjaan'] ?? null,
                    ]);
                }
            }
        }

        return redirect()->route('form.pendidikan')->with('success', 'Data Susunan Keluarga berhasil disimpan!');
    }

    // =========================================================================
    // TAHAP 3: RIWAYAT PENDIDIKAN
    // =========================================================================
    public function createPendidikan() 
    {
        $karyawan = $this->getKaryawan();
        if (!$karyawan) return redirect()->route('form.create')->withErrors('Isi Identitas Diri terlebih dahulu!');

        return view('pages.form.pendidikan', compact('karyawan'));
    }

    public function storePendidikan(Request $request)
    {
        // Ambil data karyawan yang sedang login
        $karyawan = auth()->user()->karyawan;

        if (!$karyawan) {
            return redirect()->back()->withErrors('Data Karyawan tidak ditemukan. Silakan isi Identitas Diri terlebih dahulu.');
        }

        // PENTING: Hapus data pendidikan lama agar tidak dobel saat di-edit
        \App\Models\Pendidikan::where('karyawan_id', $karyawan->id)->delete();

        // 1. PROSES SIMPAN PENDIDIKAN FORMAL
        if ($request->has('formal')) {
            foreach ($request->formal as $formal) {
                // Hanya simpan jika nama sekolahnya diketik (tidak kosong)
                if (!empty($formal['nama_institusi'])) {
                    \App\Models\Pendidikan::create([
                        'karyawan_id'    => $karyawan->id,
                        'kategori'       => 'Formal', 
                        'tingkat'        => $formal['tingkat'] ?? null, // <--- INI KUNCI AGAR DATANYA BISA MUNCUL LAGI DI FORM
                        'nama_institusi' => $formal['nama_institusi'],
                        'jurusan'        => $formal['jurusan'] ?? null,
                        'tempat'         => $formal['tempat'] ?? null,
                        'tahun'          => $formal['tahun'] ?? null,
                        'keterangan'     => $formal['keterangan'] ?? null,
                    ]);
                }
            }
        }

        // 2. PROSES SIMPAN PENDIDIKAN INFORMAL (KURSUS)
        if ($request->has('informal')) {
            foreach ($request->informal as $informal) {
                if (!empty($informal['nama_institusi'])) {
                    \App\Models\Pendidikan::create([
                        'karyawan_id'    => $karyawan->id,
                        'kategori'       => 'Informal',
                        'tingkat'        => null, // Kursus tidak butuh tingkat
                        'nama_institusi' => $informal['nama_institusi'],
                        'jurusan'        => null,
                        'tempat'         => $informal['tempat'] ?? null,
                        'tahun'          => $informal['tahun'] ?? null,
                        'keterangan'     => $informal['keterangan'] ?? null,
                    ]);
                }
            }
        }

        // Setelah beres, otomatis loncat ke form Pekerjaan!
        return redirect()->route('form.pekerjaan')->with('success', 'Data Riwayat Pendidikan berhasil disimpan!');
    }

    // =========================================================================
    // TAHAP 4: RIWAYAT PEKERJAAN
    // =========================================================================
    public function createPekerjaan() 
    {
        $karyawan = $this->getKaryawan();
        if (!$karyawan) return redirect()->route('form.create')->withErrors('Isi Identitas Diri terlebih dahulu!');

        return view('pages.form.pekerjaan', compact('karyawan'));
    }

    public function storePekerjaan(Request $request)
    {
        $karyawan = auth()->user()->karyawan;

        if (!$karyawan) {
            return redirect()->back()->withErrors('Data Karyawan tidak ditemukan.');
        }

        // Hapus data lama agar tidak menumpuk saat di-edit
        \App\Models\PengalamanKerja::where('karyawan_id', $karyawan->id)->delete();

        if ($request->has('pekerjaan')) {
            foreach ($request->pekerjaan as $kerja) {
                // Cek jika baris ini diisi, maka simpan ke DB
                if (!empty($kerja['perusahaan']) || !empty($kerja['jabatan'])) {
                    \App\Models\PengalamanKerja::create([
                        'karyawan_id' => $karyawan->id,
                        'perusahaan'  => $kerja['perusahaan'] ?? null, // <-- Ini akan menangkap inputan dari Blade
                        'jabatan'     => $kerja['jabatan'] ?? null,
                        'bagian'      => $kerja['bagian'] ?? null,
                        'masa_kerja'  => $kerja['masa_kerja'] ?? null,
                    ]);
                }
            }
        }

        // Lanjut ke form detail pekerjaan
        return redirect()->route('form.detail_pekerjaan')->with('success', 'Data Riwayat Pekerjaan berhasil disimpan!');
    }

    // =========================================================================
    // TAHAP 5: DETAIL PEKERJAAN & BAWAHAN
    // =========================================================================
    public function createDetailPekerjaan() 
    {
        // Ambil data karyawan yang sedang login
        $karyawan = $this->getKaryawan();
        
        // Lempar kembali kalau belum isi identitas diri
        if (!$karyawan) return redirect()->route('form.create')->withErrors('Isi Identitas Diri terlebih dahulu!');

        // PASTIKAN ada compact('karyawan') di sini!
        return view('pages.form.detail_pekerjaan', compact('karyawan'));
    }

    public function storeDetailPekerjaan(Request $request) 
    {
        $karyawan = $this->getKaryawan();

        // 1. Simpan/Update Esai Detail Pekerjaan
        \App\Models\DetailPekerjaan::updateOrCreate(
            ['karyawan_id' => $karyawan->id],
            $request->only(['tugas_dua_posisi_terakhir', 'struktur_organisasi', 'tanggung_jawab', 'uraian_tanggung_jawab'])
        );

        // 2. Simpan Tabel Bawahan
        // Hapus data lama agar tidak dobel saat diedit
        $karyawan->bawahans()->delete();
        
        if ($request->has('bawahan')) {
            foreach ($request->bawahan as $data) {
                // Hanya simpan jika nama bawahan diisi
                if (!empty($data['nama'])) { 
                    $karyawan->bawahans()->create([
                        'nama'   => $data['nama'],
                        'bagian' => $data['bagian'] ?? null, // Dipanggil secara eksplisit
                        'peran'  => $data['peran'] ?? null,  // Dipanggil secara eksplisit
                    ]);
                }
            }
        }
        
        return redirect()->route('form.kondisi_kerja')
                        ->with('success', 'Detail Pekerjaan Disimpan! Lanjut isi Kondisi Kerja.');
    }

    // =========================================================================
    // TAHAP 6: KONDISI KERJA
    // =========================================================================
    public function createKondisiKerja() 
    {
        $karyawan = $this->getKaryawan();
        if (!$karyawan) return redirect()->route('form.create')->withErrors('Isi Identitas Diri terlebih dahulu!');

        return view('pages.form.kondisi_kerja', compact('karyawan'));
    }

    public function storeKondisiKerja(Request $request) 
    {
        $karyawan = $this->getKaryawan();
        
        KondisiKerja::updateOrCreate(
            ['karyawan_id' => $karyawan->id],
            $request->except(['_token'])
        );
        
        return redirect()->route('form.minat_harapan')
                         ->with('success', 'Kondisi Kerja Disimpan! Lanjut isi Minat & Harapan.');
    }

    // =========================================================================
    // TAHAP 7: MINAT DAN HARAPAN
    // =========================================================================
    public function createMinatHarapan() 
    {
        $karyawan = $this->getKaryawan();
        if (!$karyawan) return redirect()->route('form.create')->withErrors('Isi Identitas Diri terlebih dahulu!');

        return view('pages.form.minat_harapan', compact('karyawan'));
    }

    public function storeMinatHarapan(Request $request)
    {
        $karyawan = auth()->user()->karyawan;

        if (!$karyawan) {
            return redirect()->back()->withErrors('Data Karyawan tidak ditemukan.');
        }

        // 1. Simpan Data Minat Harapan (Hal disukai, tidak disukai, dll)
        \App\Models\MinatHarapan::updateOrCreate(
            ['karyawan_id' => $karyawan->id],
            [
                'hal_disukai'           => $request->hal_disukai,
                'hal_tidak_disukai'     => $request->hal_tidak_disukai,
                'alasan_memilih_karier' => $request->alasan_memilih_karier,
                'aspirasi_lima_tahun'   => $request->aspirasi_lima_tahun,
            ]
        );

        // 2. Simpan Data Usaha Pencapaian Tujuan
        // PENTING: Hapus data lama dulu agar tidak dobel
        \App\Models\UsahaAspirasi::where('karyawan_id', $karyawan->id)->delete();

        if ($request->has('usaha')) {
            foreach ($request->usaha as $item) {
                // Hanya simpan jika "Bidang yang diminati" diisi
                if (!empty($item['bidang_diminati'])) {
                    \App\Models\UsahaAspirasi::create([
                        'karyawan_id'     => $karyawan->id,
                        'bidang_diminati' => $item['bidang_diminati'] ?? null,
                        'posisi'          => $item['posisi'] ?? null,          // <-- Ini yang sebelumnya lupa disave
                        'usaha_dilakukan' => $item['usaha_dilakukan'] ?? null, // <-- Ini juga lupa disave
                    ]);
                }
            }
        }

        // Otomatis loncat ke halaman Kekuatan & Kelemahan
        return redirect()->route('form.kekuatan_kelemahan')->with('success', 'Data Minat & Harapan berhasil disimpan!');
    }

    // =========================================================================
    // TAHAP 8: KEKUATAN DAN KELEMAHAN
    // =========================================================================
    public function createKekuatanKelemahan() 
    {
        $karyawan = $this->getKaryawan();
        if (!$karyawan) return redirect()->route('form.create')->withErrors('Isi Identitas Diri terlebih dahulu!');

        return view('pages.form.kekuatan_kelemahan', compact('karyawan'));
    }

    public function storeKekuatanKelemahan(Request $request) 
    {
        $karyawan = $this->getKaryawan();
        
        KekuatanKelemahan::updateOrCreate(
            ['karyawan_id' => $karyawan->id],
            $request->only(['kekuatan', 'kelemahan'])
        );
        
        return redirect()->route('form.critical_incident')->with('success', 'Kekuatan & Kelemahan Berhasil Disimpan!');
    }

    // =========================================================================
    // TAHAP 9: CRITICAL INCIDENT
    // =========================================================================
    public function createCriticalIncident() 
    {
        $karyawan = $this->getKaryawan();
        if (!$karyawan) return redirect()->route('form.create')->withErrors('Isi Identitas Diri terlebih dahulu!');

        return view('pages.form.critical_incident', compact('karyawan'));
    }

    public function storeCriticalIncident(Request $request) 
    {
        $karyawan = $this->getKaryawan();
        $karyawan->criticalIncidents()->delete();

        if($request->has('insiden')) {
            foreach($request->insiden as $data) {
                if(!empty($data['topik'])) { 
                    $karyawan->criticalIncidents()->create($data);
                }
            }
        }
        
        return redirect()->route('user.dashboard')->with('success', 'Luar Biasa! Semua Data Asesmen Berhasil Disimpan!');
    }

    public function indexCriticalIncident() 
    {
        // Untuk sekarang kita tampilkan teks biasa dulu
        return "Ini halaman Daftar Rekap Critical Incident. Nanti kita buatkan tabelnya ya!";
    }

    // =========================================================================
    // HALAMAN TABEL REKAP KARYAWAN (ADMIN)
    // =========================================================================
    public function indexKaryawan()
    {
        // Tarik semua akun dengan role 'user', dan bawa juga relasi 'karyawan'-nya (jika ada)
        $users = \App\Models\User::where('role', 'user')->with('karyawan')->get();

        return view('pages.admin.data-karyawan', [ // Sesuaikan nama view ini dengan milikmu
            'title' => 'Daftar Asesmen Peserta',
            'users' => $users // Kirim variabel $users ke view
        ]);
    }

    // Tambahkan fungsi baru ini tepat di bawahnya untuk melihat detail per orang
    public function showKaryawan($id) 
    {
        // Ambil data karyawan beserta SEMUA relasi form-nya
        $karyawan = Karyawan::with(['keluargas', 'pendidikans', 'pengalamanKerjas', 'detailPekerjaan', 'bawahans', 'kondisiKerja', 'minatHarapan', 'usahaAspirasi', 'kekuatanKelemahan', 'criticalIncidents'])->findOrFail($id);
        
        return view('pages.admin.detail-karyawan', compact('karyawan'), ['title' => 'Detail Data Karyawan']);
    }

    public function indexAdmin()
    {
        // 1. Ambil semua akun yang role-nya 'user'
        // 2. Tarik relasi 'karyawan' beserta seluruh sub-relasi formnya pakai tanda titik (.)
        $users = \App\Models\User::where('role', 'user')
            ->with([
                'karyawan',
                'karyawan.keluargas', 
                'karyawan.pendidikans', 
                'karyawan.pengalamanKerjas', 
                'karyawan.detailPekerjaan', 
                'karyawan.kondisiKerja', 
                'karyawan.minatHarapan', 
                'karyawan.kekuatanKelemahan', 
                'karyawan.criticalIncidents'
            ])->orderBy('created_at', 'desc')->get();

        return view('pages.dashboard.admin', [
            'title' => 'Admin Dashboard - Monitoring Asesmen',
            'users' => $users // <-- Perhatikan: sekarang kita kirim variabel $users
        ]);
    }

    // Menampilkan halaman form tambah akun
    public function createPeserta()
    {
        return view('pages.admin.tambah-peserta', [
            'title' => 'Tambah Akun Peserta'
        ]);
    }

    // Memproses penyimpanan akun ke database tabel users
    public function storePeserta(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nik_sap' => 'required|string|unique:users,nik_sap',
            'password' => 'required|string', // <-- Hapus |min:6 di sini
        ], [
            'nik_sap.unique' => 'NIK SAP ini sudah terdaftar di sistem!',
        ]);

        // Buat akun baru di tabel users
        \App\Models\User::create([
            'name' => $request->name,
            'nik_sap' => $request->nik_sap,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => 'user', // Otomatis diset sebagai peserta biasa
        ]);

        // Kembalikan ke halaman form dengan pesan sukses
        return redirect()->route('admin.peserta.create')->with('success', 'Akun peserta berhasil dibuat! Silakan infokan NIK SAP dan Password ke karyawan bersangkutan.');
    }
    
    public function cetakSemuaPdf()
    {
        // Ambil data user yang sudah punya karyawan
        $users = \App\Models\User::where('role', 'user')
            ->whereHas('karyawan') 
            ->with([
                'karyawan', 
                'karyawan.keluargas', 
                'karyawan.pendidikans', 
                'karyawan.pengalamanKerjas',
                'karyawan.detailPekerjaan',
                'karyawan.bawahans',
                'karyawan.kondisiKerja',
                'karyawan.minatHarapan',
                'karyawan.usahaAspirasi',
                'karyawan.kekuatanKelemahan',
                'karyawan.criticalIncidents',
            ])->orderBy('created_at', 'asc')->get();

        // Arahkan ke halaman khusus print
        return view('pages.admin.print-semua', ['users' => $users]);
    }

    public function cetakIndividuPdf($id)
    {
        // Ambil data karyawan beserta SEMUA relasi form-nya
        $karyawan = Karyawan::with([
            'keluargas', 
            'pendidikans', 
            'pengalamanKerjas', 
            'detailPekerjaan', 
            'bawahans', 
            'kondisiKerja', 
            'minatHarapan', 
            'usahaAspirasi', 
            'kekuatanKelemahan', 
            'criticalIncidents'
        ])->findOrFail($id);

        return view('pages.admin.print-individu', compact('karyawan'));
    }
}