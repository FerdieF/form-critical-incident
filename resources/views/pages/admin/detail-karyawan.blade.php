@extends('layouts.app')
{{-- detail-karyawan.blade.php --}}
@section('content')
    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between print:hidden">
        <h2 class="text-title-md2 font-bold text-black dark:text-white">
            Detail Asesmen: {{ $karyawan->nama_lengkap }}
        </h2>
        <div class="flex items-center gap-3">
            {{-- Tombol Print --}}
            <a href="{{ route('admin.print_individu_pdf', $karyawan->id) }}" target="_blank" class="inline-flex items-center justify-center gap-2 rounded-md bg-emerald-500 py-2 px-6 text-center font-medium text-white hover:bg-opacity-90 shadow-sm transition">
                {{-- Icon Printer SVG --}}
                <svg class="fill-current" width="18" height="18" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19 8H5V3H19V8ZM17 5H7V7H17V5ZM20 10H4C2.9 10 2 10.9 2 12V17H6V21H18V17H22V12C22 10.9 21.1 10 20 10ZM16 19H8V14H16V19ZM19 13C18.45 13 18 12.55 18 12C18 11.45 18.45 11 19 11C19.55 11 20 11.45 20 12C20 12.55 19.55 13 19 13Z"/>
                </svg>
                Cetak Data
            </a>

            {{-- Tombol Kembali --}}
            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center justify-center rounded-md bg-blue-600 py-2 px-6 text-center font-medium text-white hover:bg-opacity-90 shadow-sm transition">
                Kembali ke Dashboard
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6">
        
        {{-- 1. IDENTITAS DIRI --}}
        <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark p-6.5">
            <h3 class="font-bold text-black dark:text-white mb-4 border-b pb-2">I. IDENTITAS DIRI</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm font-medium">Nama Lengkap:</p>
                    <p class="text-black dark:text-white">{{ $karyawan->nama_lengkap }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium">NIK SAP:</p>
                    <p class="text-black dark:text-white">{{ $karyawan->nik_sap }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium">Tempat, Tanggal Lahir:</p>
                    <p class="text-black dark:text-white">{{ $karyawan->tempat_lahir }}, {{ $karyawan->tanggal_lahir }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium">Jenis Kelamin:</p>
                    <p class="text-black dark:text-white">{{ $karyawan->jenis_kelamin }}</p>
                </div>
            </div>
        </div>

        {{-- 2. SUSUNAN KELUARGA --}}
        <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark p-6.5">
            <h3 class="font-bold text-black dark:text-white mb-4 border-b pb-2">II. SUSUNAN KELUARGA</h3>
            @if($karyawan->keluargas->count() > 0)
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="bg-gray-2 dark:bg-meta-4 text-black dark:text-white">
                            <th class="p-2">Status</th><th class="p-2">Nama</th><th class="p-2">L/P</th><th class="p-2">Tempat, Tgl Lahir</th><th class="p-2">Pendidikan</th><th class="p-2">Pekerjaan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($karyawan->keluargas as $keluarga)
                        <tr class="border-b border-stroke dark:border-strokedark">
                            <td class="p-2">{{ $keluarga->status }}</td>
                            <td class="p-2">{{ $keluarga->nama }}</td>
                            <td class="p-2">{{ $keluarga->jenis_kelamin }}</td>
                            <td class="p-2">{{ $keluarga->tempat_lahir }}, {{ $keluarga->tanggal_lahir }}</td>
                            <td class="p-2">{{ $keluarga->pendidikan }}</td>
                            <td class="p-2">{{ $keluarga->pekerjaan }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-sm italic text-danger">Data belum diisi.</p>
            @endif
        </div>

        {{-- 3. RIWAYAT PENDIDIKAN --}}
        <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark p-6.5">
            <h3 class="font-bold text-black dark:text-white mb-4 border-b pb-2">III. RIWAYAT PENDIDIKAN</h3>
            @if($karyawan->pendidikans->count() > 0)
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="bg-gray-2 dark:bg-meta-4 text-black dark:text-white">
                            <th class="p-2">Kategori</th><th class="p-2">Tingkat/Jenis</th><th class="p-2">Nama Institusi</th><th class="p-2">Jurusan/Tempat</th><th class="p-2">Tahun</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($karyawan->pendidikans as $pendidikan)
                        <tr class="border-b border-stroke dark:border-strokedark">
                            <td class="p-2 font-medium">{{ $pendidikan->kategori }}</td>
                            <td class="p-2">{{ $pendidikan->tingkat ?? '-' }}</td>
                            <td class="p-2">{{ $pendidikan->nama_institusi }}</td>
                            <td class="p-2">{{ $pendidikan->jurusan ?? $pendidikan->tempat }}</td>
                            <td class="p-2">{{ $pendidikan->tahun }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-sm italic text-danger">Data belum diisi.</p>
            @endif
        </div>

        {{-- 4. RIWAYAT PEKERJAAN --}}
        <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark p-6.5 mt-6">
            <h3 class="font-bold text-black dark:text-white mb-4 border-b pb-2">IV. RIWAYAT PEKERJAAN</h3>
            @if($karyawan->pengalamanKerjas && $karyawan->pengalamanKerjas->count() > 0)
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="bg-gray-2 dark:bg-meta-4 text-black dark:text-white">
                            <th class="p-2">Jabatan</th>
                            <th class="p-2">Masa Kerja</th>
                            <th class="p-2">Perusahaan</th>
                            <th class="p-2">Bagian</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($karyawan->pengalamanKerjas as $kerja)
                        <tr class="border-b border-stroke dark:border-strokedark">
                            <td class="p-2">{{ $kerja->jabatan }}</td>
                            <td class="p-2">{{ $kerja->masa_kerja }}</td>
                            <td class="p-2">{{ $kerja->perusahaan }}</td>
                            <td class="p-2">{{ $kerja->bagian }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-sm italic text-danger">Data Riwayat Pekerjaan belum diisi.</p>
            @endif
        </div>

        {{-- 5. DETAIL PEKERJAAN & TANGGUNG JAWAB (SUDAH DIPERBARUI) --}}
        <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark p-6.5 mt-6">
            <h3 class="font-bold text-black dark:text-white mb-4 border-b pb-2">V. DETAIL PEKERJAAN & TANGGUNG JAWAB</h3>
            
            @if($karyawan->detailPekerjaan)
                <div class="space-y-6">
                    {{-- Posisi Terakhir --}}
                    <div>
                        <h5 class="font-semibold text-black dark:text-white mb-1">Tugas Dua Posisi Terakhir:</h5>
                        <p class="text-sm bg-gray-2 dark:bg-meta-4 p-3 rounded whitespace-pre-line">{{ $karyawan->detailPekerjaan->tugas_dua_posisi_terakhir ?? '-' }}</p>
                    </div>

                    {{-- Data Bawahan --}}
                    <div>
                        <h5 class="font-semibold text-black dark:text-white mb-2">Data Bawahan Langsung:</h5>
                        @if($karyawan->bawahans && $karyawan->bawahans->count() > 0)
                            <table class="w-full text-left text-sm border border-stroke dark:border-strokedark">
                                <thead>
                                    <tr class="bg-gray-2 dark:bg-meta-4 text-black dark:text-white">
                                        <th class="p-2 border border-stroke dark:border-strokedark">Nama</th>
                                        <th class="p-2 border border-stroke dark:border-strokedark">Bagian</th>
                                        <th class="p-2 border border-stroke dark:border-strokedark">Peran / Jabatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($karyawan->bawahans as $bawahan)
                                    <tr class="border-b border-stroke dark:border-strokedark">
                                        <td class="p-2 border border-stroke dark:border-strokedark">{{ $bawahan->nama }}</td>
                                        <td class="p-2 border border-stroke dark:border-strokedark">{{ $bawahan->bagian }}</td>
                                        <td class="p-2 border border-stroke dark:border-strokedark">{{ $bawahan->peran }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p class="text-sm italic text-gray-500">Tidak ada data bawahan.</p>
                        @endif
                    </div>

                    {{-- Struktur Organisasi --}}
                    <div>
                        <h5 class="font-semibold text-black dark:text-white mb-1">Posisi dalam Struktur Organisasi:</h5>
                        <div class="text-sm bg-gray-2 dark:bg-meta-4 p-3 rounded prose dark:prose-invert max-w-none">
                            {!! $karyawan->detailPekerjaan->struktur_organisasi ?? '<p class="italic text-gray-500">Belum dideskripsikan.</p>' !!}
                        </div>
                    </div>

                    {{-- Tanggung Jawab --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h5 class="font-semibold text-black dark:text-white mb-1">Tanggung Jawab Utama:</h5>
                            <p class="text-sm bg-gray-2 dark:bg-meta-4 p-3 rounded whitespace-pre-line">{{ $karyawan->detailPekerjaan->tanggung_jawab ?? '-' }}</p>
                        </div>
                        <div>
                            <h5 class="font-semibold text-black dark:text-white mb-1">Uraian Terperinci:</h5>
                            <p class="text-sm bg-gray-2 dark:bg-meta-4 p-3 rounded whitespace-pre-line">{{ $karyawan->detailPekerjaan->uraian_tanggung_jawab ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            @else
                <p class="text-sm italic text-danger">Data Detail Pekerjaan belum diisi.</p>
            @endif
        </div>

        {{-- BAGIAN ESAI / TEKS PANJANG (Kondisi Kerja, Minat, Kekuatan, dll) --}}
        <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark p-6.5 mt-6">
            <h3 class="font-bold text-black dark:text-white mb-4 border-b pb-2">VI - VIII. KONDISI, MINAT & KEKUATAN</h3>
            
            <div class="space-y-6">
                {{-- Kondisi Kerja --}}
                @if($karyawan->kondisiKerja)
                    <div>
                        <h5 class="font-semibold text-black dark:text-white mb-1">Kondisi Kerja Saat Ini:</h5>
                        <p class="text-sm text-primary mb-2">Penghasilan: <b>{{ $karyawan->kondisiKerja->penghasilan_sesuai }}</b> | Kondisi: <b>{{ $karyawan->kondisiKerja->kondisi_kerja_saat_ini }}</b> | Penilaian Prestasi: <b>{{ $karyawan->kondisiKerja->penilaian_prestasi }}</b></p>
                        <p class="text-sm bg-gray-2 dark:bg-meta-4 p-3 rounded">{{ $karyawan->kondisiKerja->kondisi_kerja_penjelasan ?? 'Tidak ada penjelasan rinci.' }}</p>
                    </div>
                @else
                    <p class="text-sm italic text-danger">Data Kondisi Kerja belum diisi.</p>
                @endif

                {{-- Kekuatan & Kelemahan --}}
                @if($karyawan->kekuatanKelemahan)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h5 class="font-semibold text-black dark:text-white mb-1">Kekuatan (Strong Point):</h5>
                            <p class="text-sm bg-gray-2 dark:bg-meta-4 p-3 rounded whitespace-pre-line">{{ $karyawan->kekuatanKelemahan->kekuatan }}</p>
                        </div>
                        <div>
                            <h5 class="font-semibold text-black dark:text-white mb-1">Kelemahan (Weak Point):</h5>
                            <p class="text-sm bg-gray-2 dark:bg-meta-4 p-3 rounded whitespace-pre-line">{{ $karyawan->kekuatanKelemahan->kelemahan }}</p>
                        </div>
                    </div>
                @else
                    <p class="text-sm italic text-danger">Data Kekuatan & Kelemahan belum diisi.</p>
                @endif
            </div>
        </div>

        {{-- CRITICAL INCIDENT --}}
        <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark p-6.5 mt-6">
            <h3 class="font-bold text-black dark:text-white mb-4 border-b pb-2">IX. CRITICAL INCIDENT</h3>
            @if($karyawan->criticalIncidents->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($karyawan->criticalIncidents as $insiden)
                        <div class="border border-stroke dark:border-strokedark p-4 rounded-md">
                            <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full mb-3 {{ $insiden->jenis_insiden == 'Sukses' ? 'bg-success text-white' : 'bg-danger text-white' }}">
                                Pengalaman {{ $insiden->jenis_insiden }}
                            </span>
                            <p class="text-sm mb-1"><b>Topik Kejadian</b><br>{{ $insiden->topik }}</p>
                            <p class="text-sm mb-1 mt-2"><b>Waktu Kejadian</b><br>{{ $insiden->waktu_kejadian }}</p>
                            <p class="text-sm mb-1 mt-2"><b>Kejadiannya:</b><br>{{ $insiden->kejadian }}</p>
                            <p class="text-sm mb-1 mt-2"><b>Situasinya:</b><br>{{ $insiden->situasi }}</p>
                            <p class="text-sm mb-1 mt-2"><b>Para Pelaku:</b><br>{{ $insiden->pelaku }}</p>
                            <p class="text-sm mb-1 mt-2"><b>Pikiran, Perasaan, Keinginan:</b><br>{{ $insiden->pikiran_perasaan }}</p>
                            <p class="text-sm mb-1 mt-2"><b>Perilaku:</b><br>{{ $insiden->perilaku }}</p>
                            <p class="text-sm mb-1 mt-2"><b>Hasilnya:</b><br>{{ $insiden->hasil }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm italic text-danger">Data Critical Incident belum diisi.</p>
            @endif
        </div>

    </div>
@endsection