@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Dashboard Peserta" />

    <div class="grid grid-cols-1 gap-6">
        
        {{-- PESAN SUKSES --}}
        @if(session('success'))
            <div class="flex w-full rounded-sm border-l-6 border-[#10B981] bg-[#10B981]/10 px-7 py-4 shadow-md dark:bg-[#10B981]/20">
                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-[#10B981] mr-4 text-white">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M16.6666 5L7.49992 14.1667L3.33325 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="w-full">
                    <h5 class="text-lg font-bold text-[#10B981] mb-1">Berhasil!</h5>
                    <p class="text-base text-[#10B981] font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        {{-- WELCOME CARD --}}
        <div class="rounded-sm border border-stroke bg-white px-7.5 py-6 shadow-default dark:border-gray-700 dark:bg-gray-800">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                <div class="text-center md:text-left">
                    <h4 class="mb-2 text-2xl font-bold text-black dark:text-white">
                        Selamat Datang, {{ optional(auth()->user()->karyawan)->nama_lengkap ?? auth()->user()->name }}! 👋
                    </h4>
                    <p class="font-medium text-gray-600 dark:text-gray-400">
                        Berikut adalah rekap seluruh data Asesmen HRD yang telah Anda isikan.
                    </p>
                </div>
                <a href="{{ route('form.create') }}" class="inline-flex items-center justify-center rounded-md bg-blue-600 py-3 px-10 text-center font-medium text-white hover:bg-opacity-90 shadow-sm transition">
                    Edit Data Form
                </a>
            </div>
        </div>
        
        @if($karyawan)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            {{-- 1. IDENTITAS DIRI --}}
            <div class="rounded-sm border border-stroke bg-white shadow-default p-6.5 dark:border-gray-700 dark:bg-gray-800">
                <div class="flex items-center justify-between border-b border-stroke pb-4 mb-4 dark:border-gray-700">
                    <h3 class="text-xl font-bold text-black dark:text-white">I. Identitas Diri</h3>
                    <a href="{{ route('form.create') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-primary hover:text-blue-600 dark:hover:text-blue-400 transition">
                        <svg class="fill-current" width="16" height="16" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 19H8.24264L18.8492 8.3934C19.6303 7.61235 19.6303 6.34602 18.8492 5.56497L18.435 5.15076C17.654 4.36971 16.3876 4.36971 15.6066 5.15076L5 15.7574V20H4V19ZM6 18V16.5858L15.6066 6.97918L17.0208 8.3934L7.41421 18H6Z" />
                        </svg>
                        Edit
                    </a>
                </div>

                <div class="space-y-4 text-sm">
                    <div class="flex flex-col">
                        <span class="text-gray-500 dark:text-gray-400 font-medium">Nama Lengkap:</span>
                        <span class="text-black dark:text-white font-semibold text-base">{{ $karyawan->nama_lengkap ?? '-' }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-gray-500 dark:text-gray-400 font-medium">NIK SAP:</span>
                        <span class="text-black dark:text-white font-semibold text-base">{{ $karyawan->nik_sap ?? '-' }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-gray-500 dark:text-gray-400 font-medium">Tempat, Tanggal Lahir:</span>
                        <span class="text-black dark:text-white font-semibold text-base">
                            {{ $karyawan->tempat_lahir ?? '-' }}, 
                            {{ $karyawan->tanggal_lahir ? \Carbon\Carbon::parse($karyawan->tanggal_lahir)->translatedFormat('d F Y') : '-' }}
                        </span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-gray-500 dark:text-gray-400 font-medium">Jenis Kelamin:</span>
                        <span class="text-black dark:text-white font-semibold text-base">{{ $karyawan->jenis_kelamin ?? '-' }}</span>
                    </div>
                </div>
            </div>

            {{-- 2. SUSUNAN KELUARGA (Sudah dibersihkan dari duplikat dan mt-6) --}}
            <div class="rounded-sm border border-stroke bg-white shadow-default p-6.5 dark:border-gray-700 dark:bg-gray-800">
                <div class="flex items-center justify-between border-b border-stroke pb-4 mb-4 dark:border-gray-700">
                    <h3 class="text-xl font-bold text-black dark:text-white">II. Susunan Keluarga</h3>
                    <a href="{{ route('form.keluarga') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-primary hover:text-blue-600 dark:hover:text-blue-400 transition">
                        <svg class="fill-current" width="16" height="16" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 19H8.24264L18.8492 8.3934C19.6303 7.61235 19.6303 6.34602 18.8492 5.56497L18.435 5.15076C17.654 4.36971 16.3876 4.36971 15.6066 5.15076L5 15.7574V20H4V19ZM6 18V16.5858L15.6066 6.97918L17.0208 8.3934L7.41421 18H6Z" />
                        </svg>
                        Edit
                    </a>
                </div>

                <div class="overflow-x-auto rounded-md border border-stroke dark:border-gray-700">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100 dark:bg-gray-700 text-black dark:text-white">
                                <th class="p-3 border-b border-stroke dark:border-gray-600 text-sm font-bold">Nama</th>
                                <th class="p-3 border-b border-stroke dark:border-gray-600 text-sm font-bold text-center">Hubungan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($karyawan->keluargas && $karyawan->keluargas->count() > 0)
                                @foreach($karyawan->keluargas as $keluarga)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-600/50 transition border-b border-stroke dark:border-gray-700 last:border-none">
                                        <td class="p-3 text-black dark:text-white text-sm">
                                            {{ $keluarga->nama }}
                                        </td>
                                        <td class="p-3 text-black dark:text-white text-sm text-center">
                                            {{ $keluarga->hubungan ?? $keluarga->status }}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="2" class="p-4 text-center text-gray-500 dark:text-gray-400 italic text-sm">
                                        Data keluarga belum ditambahkan.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- 3. RIWAYAT PENDIDIKAN --}}
            <div class="rounded-sm border border-stroke bg-white px-6 py-5 shadow-default dark:border-gray-700 dark:bg-gray-800">
                <div class="flex items-center justify-between border-b border-stroke pb-3 mb-4 dark:border-gray-700">
                    <h4 class="text-title-sm font-bold !text-black dark:!text-white">
                        III. Riwayat Pendidikan
                    </h4>
                    <a href="{{ route('form.pendidikan') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-primary hover:text-blue-700 transition">
                        <svg class="fill-current" width="16" height="16" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 19H8.24264L18.8492 8.3934C19.6303 7.61235 19.6303 6.34602 18.8492 5.56497L18.435 5.15076C17.654 4.36971 16.3876 4.36971 15.6066 5.15076L5 15.7574V20H4V19ZM6 18V16.5858L15.6066 6.97918L17.0208 8.3934L7.41421 18H6Z" />
                        </svg>
                        Edit
                    </a>
                </div>
                @if($karyawan->pendidikans && $karyawan->pendidikans->count() > 0)
                    <div class="space-y-3">
                        @foreach($karyawan->pendidikans as $pendidikan)
                        <div class="flex items-center justify-between p-3 rounded-lg border border-stroke dark:border-gray-700 bg-gray-50 dark:bg-gray-800/30 shadow-sm">
                            <div>
                                <p class="!text-black dark:!text-white font-bold">{{ $pendidikan->nama_institusi }}</p>
                                <p class="text-xs !text-gray-600 dark:!text-gray-400">Tahun: {{ $pendidikan->tahun }}</p>
                            </div>
                           <span class="text-[10px] font-bold uppercase px-2 py-1 rounded bg-primary/10 !text-primary dark:bg-primary/20 dark:!text-blue-400">
                                {{ $pendidikan->tingkat ?? $pendidikan->kategori ?? 'Pendidikan' }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm italic !text-gray-500 dark:!text-gray-400 py-4 text-center">Belum ada data pendidikan.</p>
                @endif
            </div>

            {{-- 4. RIWAYAT PEKERJAAN --}}
            <div class="rounded-sm border border-stroke bg-white px-6 py-5 shadow-default dark:border-gray-700 dark:bg-gray-800">
                <div class="flex items-center justify-between border-b border-stroke pb-3 mb-4 dark:border-gray-700">
                    <h4 class="text-title-sm font-bold !text-black dark:!text-white">
                        IV. Riwayat Pekerjaan
                    </h4>
                    <a href="{{ route('form.pekerjaan') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-primary hover:text-blue-700 transition">
                        <svg class="fill-current" width="16" height="16" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 19H8.24264L18.8492 8.3934C19.6303 7.61235 19.6303 6.34602 18.8492 5.56497L18.435 5.15076C17.654 4.36971 16.3876 4.36971 15.6066 5.15076L5 15.7574V20H4V19ZM6 18V16.5858L15.6066 6.97918L17.0208 8.3934L7.41421 18H6Z" />
                        </svg>
                        Edit
                    </a>
                </div>
                @if($karyawan->pengalamanKerjas && $karyawan->pengalamanKerjas->count() > 0)
                    <div class="space-y-3">
                        @foreach($karyawan->pengalamanKerjas as $pekerjaan)
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between p-3 rounded-lg border border-stroke dark:border-gray-700 bg-gray-50 dark:bg-gray-800/30 shadow-sm gap-2">
                            <div>
                                <p class="!text-black dark:!text-white font-bold text-base">
                                    {{-- PERBAIKAN DI SINI: pakai ->perusahaan --}}
                                    {{ $pekerjaan->perusahaan ?? 'Perusahaan Tidak Diisi' }}
                                </p>
                                <p class="text-sm !text-gray-600 dark:!text-gray-400">
                                    Posisi: {{ $pekerjaan->jabatan ?? '-' }} 
                                    @if($pekerjaan->bagian)
                                        (Bagian: {{ $pekerjaan->bagian }})
                                    @endif
                                </p>
                            </div>
                            <div class="shrink-0">
                                <span class="inline-block text-xs font-medium px-2.5 py-1 rounded border border-gray-200 bg-white text-gray-700 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-300 shadow-sm">
                                    ⏱️ {{ $pekerjaan->masa_kerja ?? 'Masa kerja tidak diisi' }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm italic !text-gray-500 dark:!text-gray-400 py-4 text-center">Belum ada data pekerjaan.</p>
                @endif
            </div>

            {{-- 5. DETAIL PEKERJAAN --}}
            <div class="rounded-sm border border-stroke bg-white px-6 py-5 shadow-default dark:border-gray-700 dark:bg-gray-800 md:col-span-2">
                <div class="flex items-center justify-between border-b border-stroke pb-3 mb-4 dark:border-gray-700">
                    <h4 class="text-title-sm font-bold text-black dark:text-white">
                        V. Detail Pekerjaan & Tanggung Jawab
                    </h4>
                    <a href="{{ route('form.detail_pekerjaan') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-primary hover:text-blue-700 transition">
                        <svg class="fill-current" width="16" height="16" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 19H8.24264L18.8492 8.3934C19.6303 7.61235 19.6303 6.34602 18.8492 5.56497L18.435 5.15076C17.654 4.36971 16.3876 4.36971 15.6066 5.15076L5 15.7574V20H4V19ZM6 18V16.5858L15.6066 6.97918L17.0208 8.3934L7.41421 18H6Z" />
                        </svg>
                        Edit
                    </a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="p-4 bg-gray-50 dark:bg-gray-800/30 rounded-md">
                        <label class="text-xs font-bold !text-gray-500 dark:!text-gray-400 uppercase tracking-wider block mb-2">
                            Tugas Dua Posisi Terakhir
                        </label>
                        <p class="text-sm text-black dark:text-white leading-relaxed">
                            {{ $karyawan->detailPekerjaan->tugas_dua_posisi_terakhir ?? 'Belum diisi' }}
                        </p>
                    </div>
                    <div class="p-4 bg-gray-50 dark:bg-gray-800/30 rounded-md">
                        <label class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider block mb-2">Uraian Tanggung Jawab</label>
                        <p class="text-sm text-black dark:text-white leading-relaxed">{{ $karyawan->detailPekerjaan->uraian_tanggung_jawab ?? 'Belum diisi' }}</p>
                    </div>
                </div>
            </div>

            {{-- 6. KONDISI KERJA --}}
            <div class="rounded-sm border border-stroke bg-white px-6 py-5 shadow-default dark:border-gray-700 dark:bg-gray-800">
                <div class="flex items-center justify-between border-b border-stroke pb-3 mb-4 dark:border-gray-700">
                    <h4 class="text-title-sm font-bold text-black dark:text-white">
                        VI. Kondisi Kerja
                    </h4>
                    <a href="{{ route('form.kondisi_kerja') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-primary hover:text-blue-700 transition">
                        <svg class="fill-current" width="16" height="16" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 19H8.24264L18.8492 8.3934C19.6303 7.61235 19.6303 6.34602 18.8492 5.56497L18.435 5.15076C17.654 4.36971 16.3876 4.36971 15.6066 5.15076L5 15.7574V20H4V19ZM6 18V16.5858L15.6066 6.97918L17.0208 8.3934L7.41421 18H6Z" />
                        </svg>
                        Edit
                    </a>
                </div>
                <div class="flex flex-col gap-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium !text-gray-600 dark:!text-gray-400">Kesesuaian Penghasilan</span>
                        <span class="px-3 py-1 rounded-full bg-blue-500/10 text-blue-500 text-xs font-bold border border-blue-500/20">
                            {{ $karyawan->kondisiKerja->penghasilan_sesuai ?? 'Belum diisi' }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500 font-medium">Kondisi Kerja Saat Ini</span>
                        <span class="px-3 py-1 rounded-full bg-green-500/10 text-green-500 text-xs font-bold border border-green-500/20">
                            {{ $karyawan->kondisiKerja->kondisi_kerja_saat_ini ?? 'Belum diisi' }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- 7. MINAT HARAPAN --}}
            <div class="rounded-sm border border-stroke bg-white px-6 py-5 shadow-default dark:border-gray-700 dark:bg-gray-800">
                <div class="flex items-center justify-between border-b border-stroke pb-3 mb-4 dark:border-gray-700">
                    <h4 class="text-title-sm font-bold text-black dark:text-white">
                        VII. Minat & Harapan
                    </h4>
                    <a href="{{ route('form.minat_harapan') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-primary hover:text-blue-700 transition">
                        <svg class="fill-current" width="16" height="16" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 19H8.24264L18.8492 8.3934C19.6303 7.61235 19.6303 6.34602 18.8492 5.56497L18.435 5.15076C17.654 4.36971 16.3876 4.36971 15.6066 5.15076L5 15.7574V20H4V19ZM6 18V16.5858L15.6066 6.97918L17.0208 8.3934L7.41421 18H6Z" />
                        </svg>
                        Edit
                    </a>
                </div>
                <div class="space-y-4">
                    <div>
                        <span class="text-[10px] font-bold !text-gray-500 dark:!text-gray-400 uppercase block mb-1">
                            Hal Disukai
                        </span>
                        <p class="text-sm text-black dark:text-white">
                            {{ $karyawan->minatHarapan->hal_disukai ?? 'Belum diisi' }}
                        </p>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold text-gray-500 dark:text-gray-400 uppercase block mb-1">
                            Hal Tidak Disukai
                        </span>
                        <p class="text-sm text-black dark:text-white">
                            {{ $karyawan->minatHarapan->hal_tidak_disukai ?? 'Belum diisi' }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- 8. KEKUATAN & KELEMAHAN --}}
            <div class="md:col-span-2 rounded-sm border border-stroke bg-white px-6 py-5 shadow-default dark:border-gray-700 dark:bg-gray-800">
                <div class="flex items-center justify-between border-b border-stroke pb-3 mb-4 dark:border-gray-700">
                    <h4 class="text-title-sm font-bold text-black dark:text-white">
                        VIII. Kekuatan & Kelemahan (SWOT)
                    </h4>
                    <a href="{{ route('form.kekuatan_kelemahan') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-primary hover:text-blue-700 transition">
                        <svg class="fill-current" width="16" height="16" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 19H8.24264L18.8492 8.3934C19.6303 7.61235 19.6303 6.34602 18.8492 5.56497L18.435 5.15076C17.654 4.36971 16.3876 4.36971 15.6066 5.15076L5 15.7574V20H4V19ZM6 18V16.5858L15.6066 6.97918L17.0208 8.3934L7.41421 18H6Z" />
                        </svg>
                        Edit
                    </a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-4 rounded border-l-4 border-success bg-success/5">
                        <strong class="text-success dark:!text-green-400 text-xs uppercase block mb-2 font-bold">
                            Kekuatan (Strength)
                        </strong>
                        <p class="text-sm !text-black dark:!text-white whitespace-pre-line">{{ $karyawan->kekuatanKelemahan->kekuatan ?? 'Belum diisi' }}</p>
                    </div>

                    <div class="p-4 rounded border-l-4 border-danger bg-danger/5">
                        <strong class="text-danger dark:!text-red-400 text-xs uppercase block mb-2 font-bold">
                            Kelemahan (Weakness)
                        </strong>
                        <p class="text-sm !text-black dark:!text-white whitespace-pre-line">{{ $karyawan->kekuatanKelemahan->kelemahan ?? 'Belum diisi' }}</p>
                    </div>
                </div>
            </div>

            {{-- 9. CRITICAL INCIDENT --}}
            <div class="md:col-span-2 rounded-sm border border-stroke bg-white px-6 py-5 shadow-default dark:border-gray-700 dark:bg-gray-800">
                <div class="flex items-center justify-between border-b border-stroke pb-3 mb-4 dark:border-gray-700">
                    <h4 class="text-title-sm font-bold text-black dark:text-white">
                        IX. Critical Incident
                    </h4>
                    <a href="{{ route('form.critical_incident') }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-primary hover:text-blue-700 transition">
                        <svg class="fill-current" width="16" height="16" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 19H8.24264L18.8492 8.3934C19.6303 7.61235 19.6303 6.34602 18.8492 5.56497L18.435 5.15076C17.654 4.36971 16.3876 4.36971 15.6066 5.15076L5 15.7574V20H4V19ZM6 18V16.5858L15.6066 6.97918L17.0208 8.3934L7.41421 18H6Z" />
                        </svg>
                        Edit
                    </a>
                </div>
                @if($karyawan->criticalIncidents && $karyawan->criticalIncidents->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($karyawan->criticalIncidents as $incident)
                        <div class="p-4 rounded border border-stroke dark:border-gray-700 bg-gray-50 dark:bg-gray-800/40 shadow-sm">
                            <div class="flex justify-between items-start mb-2">
                                <h5 class="font-bold !text-black dark:!text-white text-sm line-clamp-1">{{ $incident->topik }}</h5>
                                <span class="text-[9px] px-2 py-0.5 rounded-full {{ $incident->jenis_insiden == 'Sukses' ? 'bg-success/10 text-success dark:!text-green-400 border border-success/20' : 'bg-danger/10 text-danger dark:!text-red-400 border border-danger/20' }}">
                                    {{ $incident->jenis_insiden }}
                                </span>
                            </div>
                            <p class="text-xs !text-gray-600 dark:!text-gray-300 line-clamp-2">{{ $incident->kejadian ?? 'Detail kejadian tidak diisi.' }}</p>
                        </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm italic text-gray-400 text-center py-4">Belum ada data Critical Incident.</p>
                @endif
            </div>

        </div>
        @else
            {{-- EMPTY STATE --}}
            <div class="rounded-sm border border-stroke bg-white px-7.5 py-12 text-center shadow-default dark:border-gray-700 dark:bg-gray-800">
                <div class="mx-auto mb-6 flex h-20 w-20 items-center justify-center rounded-full bg-primary/10 text-primary">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2V6M12 18V22M4.93 4.93L7.76 7.76M16.24 16.24L19.07 19.07M2 12H6M18 12H22M4.93 19.07L7.76 16.24M16.24 7.76L19.07 4.93" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <h4 class="mb-2 text-2xl font-bold text-black dark:text-white">Form Belum Dimulai</h4>
                <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-sm mx-auto">Anda belum memulai pengisian data asesmen. Silakan klik tombol di bawah untuk memulai.</p>
                <a href="{{ route('form.create') }}" class="inline-flex items-center justify-center rounded-md bg-primary py-3 px-10 text-center font-medium text-white hover:bg-opacity-90 transition shadow-sm">
                    Mulai Isi Form
                </a>
            </div>
        @endif
        
    </div>
@endsection