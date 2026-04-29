@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Data Minat dan Harapan" />

    {{-- TAMBAHKAN STYLE INI UNTUK MEMAKSA DARK MODE (JALUR DARURAT) --}}
    <style>
        .dark .bg-white {
            background-color: #24303F !important; /* Warna kontainer utama */
            border-color: #313D4A !important;
        }

        .dark .text-black, 
        .dark h3, 
        .dark h4, 
        .dark label,
        .dark p,
        .dark th {
            color: #ffffff !important; /* Paksa teks jadi putih */
        }

        .dark textarea,
        .dark input[type="text"] {
            background-color: #1D2A39 !important; /* Warna background input & textarea */
            border-color: #313D4A !important;
            color: #ffffff !important;
        }

        /* Khusus untuk header tabel agar tidak belang */
        .dark .bg-gray-2 {
            background-color: #313D4A !important;
        }

        /* Khusus untuk garis bawah tabel */
        .dark .border-\[\#eee\] {
            border-color: #313D4A !important;
        }
    </style>

    <div class="grid grid-cols-1 gap-6">
        {{-- ... Sisa kodemu yang ada di bawahnya biarkan sama persis ... --}}
        @if(session('success'))
            <div class="mb-6 flex w-full rounded border-l-6 border-[#10B981] bg-[#10B981] px-7 py-4 shadow-md">
                <div class="w-full">
                    <h5 class="text-lg font-bold text-white mb-1">Berhasil!</h5>
                    <p class="text-base text-white font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

<div class="rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
    <div class="border-b border-stroke py-4 px-6.5 dark:border-strokedark">
        <h3 class="font-medium text-black dark:text-white">
            {{-- Ubah variabel jadi $karyawan --}}
            VII. MINAT DAN HARAPAN ({{ $karyawan->nama_lengkap ?? '' }})
        </h3>
    </div>
    
    <form action="{{ route('form.minat_harapan.store') }}" method="POST">
                @csrf
                <div class="p-6.5">

                    {{-- Variabel bantuan biar kodenya gak kepanjangan --}}
                    @php $minat = $karyawan->minatHarapan ?? null; @endphp

                    <div class="mb-6">
                        <label class="mb-2.5 block font-medium text-black dark:text-white">Apakah yang Anda sukai dari pekerjaan Anda sekarang? (kondisi, tugas-tugas, dsb) Mengapa?</label>
                        <textarea name="hal_disukai" rows="3" class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 outline-none focus:border-primary dark:border-form-strokedark dark:bg-form-input dark:text-white">{{ $minat->hal_disukai ?? '' }}</textarea>
                    </div>

                    <div class="mb-6">
                        <label class="mb-2.5 block font-medium text-black dark:text-white">Apa yang paling Anda tidak sukai dari pekerjaan/jabatan Anda sekarang? (kondisi, tugas-tugas, dsb) Mengapa?</label>
                        <textarea name="hal_tidak_disukai" rows="3" class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 outline-none focus:border-primary dark:border-form-strokedark dark:bg-form-input dark:text-white">{{ $minat->hal_tidak_disukai ?? '' }}</textarea>
                    </div>

                    <div class="mb-6">
                        <label class="mb-2.5 block font-medium text-black dark:text-white">Mengapa Anda memilih karier (tipe pekerjaan) di bidang yang Anda tekuni sekarang ini?</label>
                        <textarea name="alasan_memilih_karier" rows="3" class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 outline-none focus:border-primary dark:border-form-strokedark dark:bg-form-input dark:text-white">{{ $minat->alasan_memilih_karier ?? '' }}</textarea>
                    </div>

                    <div class="mb-8">
                        <label class="mb-2.5 block font-medium text-black dark:text-white">Uraikan ASPIRASI karier Anda dalam lima tahun mendatang!</label>
                        <textarea name="aspirasi_lima_tahun" rows="3" class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 outline-none focus:border-primary dark:border-form-strokedark dark:bg-form-input dark:text-white">{{ $minat->aspirasi_lima_tahun ?? '' }}</textarea>
                    </div>

                    <h4 class="font-bold text-black dark:text-white mb-4 mt-8">Usaha-usaha Pencapaian Tujuan</h4>
                    <p class="mb-4 text-sm text-black dark:text-white">Uraikan usaha-usaha yang sudah Anda lakukan untuk mencapai tujuan tersebut (misal: training, kursus, dll).</p>
                    <div class="overflow-x-auto mb-8">
                        <table class="w-full table-auto">
                            <thead>
                                <tr class="bg-gray-2 text-left dark:bg-meta-4">
                                    <th class="py-4 px-4 font-medium text-black dark:text-white min-w-[200px]">Bidang yang diminati</th>
                                    <th class="py-4 px-4 font-medium text-black dark:text-white min-w-[200px]">Posisi</th>
                                    <th class="py-4 px-4 font-medium text-black dark:text-white min-w-[250px]">Usaha-usaha yang dilakukan</th>
                                    <th class="py-4 px-4 font-medium text-black dark:text-white text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-usaha">
                                @php
                                    // Tambahkan ()->get() agar Laravel mengambil seluruh data sebagai Collection
                                    $usahaList = isset($karyawan) 
                                        ? $karyawan->usahaAspirasi()->get()->filter(function($item) {
                                            return !empty($item->bidang_diminati);
                                        })->values() 
                                        : collect();
                                @endphp

                                @if($usahaList->count() > 0)
                                    @foreach($usahaList as $index => $usaha)
                                    <tr>
                                        <td class="border-b border-[#eee] py-4 px-2 dark:border-strokedark">
                                            <input type="text" name="usaha[{{ $index }}][bidang_diminati]" value="{{ $usaha->bidang_diminati }}" class="w-full rounded border-[1.5px] border-stroke bg-transparent px-3 py-2 outline-none focus:border-primary dark:border-form-strokedark dark:bg-form-input dark:text-white">
                                        </td>
                                        <td class="border-b border-[#eee] py-4 px-2 dark:border-strokedark">
                                            <input type="text" name="usaha[{{ $index }}][posisi]" value="{{ $usaha->posisi ?? '' }}" class="w-full rounded border-[1.5px] border-stroke bg-transparent px-3 py-2 outline-none focus:border-primary dark:border-form-strokedark dark:bg-form-input dark:text-white">
                                        </td>
                                        <td class="border-b border-[#eee] py-4 px-2 dark:border-strokedark">
                                            <input type="text" name="usaha[{{ $index }}][usaha_dilakukan]" value="{{ $usaha->usaha_dilakukan ?? '' }}" class="w-full rounded border-[1.5px] border-stroke bg-transparent px-3 py-2 outline-none focus:border-primary dark:border-form-strokedark dark:bg-form-input dark:text-white">
                                        </td>
                                        <td class="border-b border-[#eee] py-4 px-2 dark:border-strokedark text-center">
                                            <button type="button" class="text-[#dc3545] hover:text-opacity-70 font-medium btn-hapus text-sm transition-all">Hapus</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    {{-- Tampilkan 1 baris saja jika tidak ada data lama yang valid --}}
                                    <tr>
                                        <td class="border-b border-[#eee] py-4 px-2 dark:border-strokedark">
                                            <input type="text" name="usaha[0][bidang_diminati]" class="w-full rounded border-[1.5px] border-stroke bg-transparent px-3 py-2 outline-none focus:border-primary dark:border-form-strokedark dark:bg-form-input dark:text-white">
                                        </td>
                                        <td class="border-b border-[#eee] py-4 px-2 dark:border-strokedark">
                                            <input type="text" name="usaha[0][posisi]" class="w-full rounded border-[1.5px] border-stroke bg-transparent px-3 py-2 outline-none focus:border-primary dark:border-form-strokedark dark:bg-form-input dark:text-white">
                                        </td>
                                        <td class="border-b border-[#eee] py-4 px-2 dark:border-strokedark">
                                            <input type="text" name="usaha[0][usaha_dilakukan]" class="w-full rounded border-[1.5px] border-stroke bg-transparent px-3 py-2 outline-none focus:border-primary dark:border-form-strokedark dark:bg-form-input dark:text-white">
                                        </td>
                                        <td class="border-b border-[#eee] py-4 px-2 dark:border-strokedark text-center">
                                            <button type="button" class="text-[#dc3545] hover:text-opacity-70 font-medium btn-hapus text-sm transition-all">Hapus</button>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <button type="button" id="btn-tambah-usaha" class="mt-4 flex justify-center rounded border border-stroke py-2 px-4 font-medium text-black dark:text-white hover:shadow-1 dark:border-strokedark transition-all text-sm">
                            + Tambah Usaha
                        </button>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="submit" class="flex w-full md:w-1/3 justify-center rounded bg-green-500 p-3 font-medium text-white transition hover:bg-green-600">
                            Simpan Minat & Harapan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const btnTambah = document.getElementById('btn-tambah-usaha');
            const tbody = document.getElementById('tbody-usaha');
            
            // Sinkronisasi index array Javascript dengan data yang ditarik dari database
            let arrayIndex = {{ isset($karyawan) && $karyawan->usahaAspirasi && $karyawan->usahaAspirasi->count() > 0 ? $karyawan->usahaAspirasi->count() : 1 }};

            btnTambah.addEventListener('click', function () {
                const barisBaru = `
                    <tr>
                        <td class="border-b border-[#eee] py-4 px-2 dark:border-strokedark">
                            <input type="text" name="usaha[${arrayIndex}][bidang_diminati]" class="w-full rounded border-[1.5px] border-stroke bg-transparent px-3 py-2 outline-none focus:border-primary dark:border-form-strokedark dark:bg-form-input dark:text-white">
                        </td>
                        <td class="border-b border-[#eee] py-4 px-2 dark:border-strokedark">
                            <input type="text" name="usaha[${arrayIndex}][posisi]" class="w-full rounded border-[1.5px] border-stroke bg-transparent px-3 py-2 outline-none focus:border-primary dark:border-form-strokedark dark:bg-form-input dark:text-white">
                        </td>
                        <td class="border-b border-[#eee] py-4 px-2 dark:border-strokedark">
                            <input type="text" name="usaha[${arrayIndex}][usaha_dilakukan]" class="w-full rounded border-[1.5px] border-stroke bg-transparent px-3 py-2 outline-none focus:border-primary dark:border-form-strokedark dark:bg-form-input dark:text-white">
                        </td>
                        <td class="border-b border-[#eee] py-4 px-2 dark:border-strokedark text-center">
                            <button type="button" class="text-[#dc3545] hover:text-opacity-70 font-medium btn-hapus text-sm transition-all">Hapus</button>
                        </td>
                    </tr>
                `;
                tbody.insertAdjacentHTML('beforeend', barisBaru);
                arrayIndex++;
            });

            tbody.addEventListener('click', function(e) {
                if (e.target.classList.contains('btn-hapus')) {
                    e.target.closest('tr').remove();
                }
            });
        });
    </script>
@endsection