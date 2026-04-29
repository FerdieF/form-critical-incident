@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Data Riwayat Pendidikan" />

    <div class="grid grid-cols-1 gap-6">
        @if(session('success'))
            <div class="mb-6 flex w-full rounded border-l-6 border-[#10B981] bg-[#10B981]/10 px-7 py-4 shadow-md dark:bg-[#10B981]/20">
                <div class="w-full">
                    <h5 class="text-lg font-bold text-[#10B981] mb-1">Berhasil!</h5>
                    <p class="text-base text-[#10B981] font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-gray-700 dark:bg-gray-800">
            <div class="border-b border-stroke py-4 px-6.5 dark:border-gray-700">
                <h3 class="font-bold text-black dark:text-white uppercase">
                    III. Riwayat Pendidikan
                </h3>
            </div>
            
            <form action="{{ route('form.pendidikan.store') }}" method="POST">
                @csrf
                
                <input type="hidden" name="karyawan_id" value="{{ optional(auth()->user()->karyawan)->id }}">

                <div class="p-6.5">
                    
                    <h4 class="font-bold text-black dark:text-white mb-4">A. Pendidikan Formal</h4>
                    <div class="overflow-x-auto mb-8 rounded-md border border-stroke dark:border-gray-700">
                        <table class="w-full table-auto">
                            <thead>
                                <tr class="bg-gray-100 text-left dark:bg-gray-700">
                                    <th class="py-3 px-4 font-bold text-black dark:text-white border-b border-stroke dark:border-gray-600">Tingkat</th>
                                    <th class="py-3 px-4 font-bold text-black dark:text-white border-b border-stroke dark:border-gray-600 min-w-[200px]">Nama Sekolah</th>
                                    <th class="py-3 px-4 font-bold text-black dark:text-white border-b border-stroke dark:border-gray-600">Jurusan</th>
                                    <th class="py-3 px-4 font-bold text-black dark:text-white border-b border-stroke dark:border-gray-600">Tempat</th>
                                    <th class="py-3 px-4 font-bold text-black dark:text-white border-b border-stroke dark:border-gray-600 min-w-[150px]">Thn s/d Thn</th>
                                    <th class="py-3 px-4 font-bold text-black dark:text-white border-b border-stroke dark:border-gray-600">Keterangan</th>
                                    <th class="py-3 px-4 font-bold text-black dark:text-white border-b border-stroke dark:border-gray-600 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-formal">
                                @php 
                                    $tingkat_formal = ['Pasca S1', 'S1', 'Akademi', 'SLTA']; 
                                    // Filter data pendidikan HANYA yang berkategori 'Formal'
                                    $pendidikanFormal = $karyawan ? $karyawan->pendidikans->where('kategori', 'Formal') : collect();
                                @endphp
                                
                                @foreach($tingkat_formal as $index => $tingkat)
                                @php
                                    // Cari apakah ada data lama untuk tingkat ini (misal: S1)
                                    $dataLama = $pendidikanFormal->firstWhere('tingkat', $tingkat);
                                @endphp
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition">
                                    <td class="border-b border-[#eee] py-3 px-4 dark:border-gray-700">
                                        <input type="hidden" name="formal[{{ $index }}][tingkat]" value="{{ $tingkat }}">
                                        <span class="text-black dark:text-white font-bold">{{ $tingkat }}</span>
                                    </td>
                                    <td class="border-b border-[#eee] py-3 px-2 dark:border-gray-700">
                                        <input type="text" name="formal[{{ $index }}][nama_institusi]" value="{{ $dataLama->nama_institusi ?? '' }}" class="w-full rounded border-[1.5px] border-stroke bg-white px-3 py-2 outline-none focus:border-primary dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                    </td>
                                    <td class="border-b border-[#eee] py-3 px-2 dark:border-gray-700">
                                        <input type="text" name="formal[{{ $index }}][jurusan]" value="{{ $dataLama->jurusan ?? '' }}" class="w-full rounded border-[1.5px] border-stroke bg-white px-3 py-2 outline-none focus:border-primary dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                    </td>
                                    <td class="border-b border-[#eee] py-3 px-2 dark:border-gray-700">
                                        <input type="text" name="formal[{{ $index }}][tempat]" value="{{ $dataLama->tempat ?? '' }}" class="w-full rounded border-[1.5px] border-stroke bg-white px-3 py-2 outline-none focus:border-primary dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                    </td>
                                    <td class="border-b border-[#eee] py-3 px-2 dark:border-gray-700">
                                        <input type="text" name="formal[{{ $index }}][tahun]" value="{{ $dataLama->tahun ?? '' }}" placeholder="Contoh: 2010 - 2014" class="w-full rounded border-[1.5px] border-stroke bg-white px-3 py-2 outline-none focus:border-primary dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                    </td>
                                    <td class="border-b border-[#eee] py-3 px-2 dark:border-gray-700">
                                        <input type="text" name="formal[{{ $index }}][keterangan]" value="{{ $dataLama->keterangan ?? '' }}" class="w-full rounded border-[1.5px] border-stroke bg-white px-3 py-2 outline-none focus:border-primary dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                    </td>
                                    <td class="border-b border-[#eee] py-3 px-2 dark:border-gray-700 text-center">
                                        <button type="button" class="text-red-500 hover:text-red-700 font-medium btn-hapus-formal text-sm transition-all">Hapus</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <h4 class="font-bold text-black dark:text-white mb-4">B. Pendidikan Informal (Kursus / Training)</h4>
                    <div class="overflow-x-auto mb-6 rounded-md border border-stroke dark:border-gray-700">
                        <table class="w-full table-auto">
                            <thead>
                                <tr class="bg-gray-100 text-left dark:bg-gray-700">
                                    <th class="py-3 px-4 font-bold text-black dark:text-white border-b border-stroke dark:border-gray-600 min-w-[250px]">Jenis Kursus / Training</th>
                                    <th class="py-3 px-4 font-bold text-black dark:text-white border-b border-stroke dark:border-gray-600">Tempat</th>
                                    <th class="py-3 px-4 font-bold text-black dark:text-white border-b border-stroke dark:border-gray-600">Tahun</th>
                                    <th class="py-3 px-4 font-bold text-black dark:text-white border-b border-stroke dark:border-gray-600">Keterangan</th>
                                    <th class="py-3 px-4 font-bold text-black dark:text-white border-b border-stroke dark:border-gray-600 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-informal">
                                @php
                                    // Filter data pendidikan HANYA yang berkategori 'Informal'
                                    $pendidikanInformal = $karyawan ? $karyawan->pendidikans->where('kategori', 'Informal')->values() : collect();
                                @endphp

                                @if($pendidikanInformal->count() > 0)
                                    {{-- Jika sudah ada data kursus sebelumnya, tampilkan semuanya --}}
                                    @foreach($pendidikanInformal as $index => $informal)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition">
                                        <td class="border-b border-[#eee] py-3 px-2 dark:border-gray-700">
                                            <input type="text" name="informal[{{ $index }}][nama_institusi]" value="{{ $informal->nama_institusi ?? '' }}" class="w-full rounded border-[1.5px] border-stroke bg-white px-3 py-2 outline-none focus:border-primary dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                        </td>
                                        <td class="border-b border-[#eee] py-3 px-2 dark:border-gray-700">
                                            <input type="text" name="informal[{{ $index }}][tempat]" value="{{ $informal->tempat ?? '' }}" class="w-full rounded border-[1.5px] border-stroke bg-white px-3 py-2 outline-none focus:border-primary dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                        </td>
                                        <td class="border-b border-[#eee] py-3 px-2 dark:border-gray-700">
                                            <input type="text" name="informal[{{ $index }}][tahun]" value="{{ $informal->tahun ?? '' }}" class="w-full rounded border-[1.5px] border-stroke bg-white px-3 py-2 outline-none focus:border-primary dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                        </td>
                                        <td class="border-b border-[#eee] py-3 px-2 dark:border-gray-700">
                                            <input type="text" name="informal[{{ $index }}][keterangan]" value="{{ $informal->keterangan ?? '' }}" class="w-full rounded border-[1.5px] border-stroke bg-white px-3 py-2 outline-none focus:border-primary dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                        </td>
                                        <td class="border-b border-[#eee] py-3 px-2 dark:border-gray-700 text-center">
                                            <button type="button" class="text-red-500 hover:text-red-700 font-medium btn-hapus-kursus text-sm transition-all">Hapus</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    {{-- Jika kosong / belum pernah isi, tampilkan 1 baris input kosong --}}
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition">
                                        <td class="border-b border-[#eee] py-3 px-2 dark:border-gray-700">
                                            <input type="text" name="informal[0][nama_institusi]" class="w-full rounded border-[1.5px] border-stroke bg-white px-3 py-2 outline-none focus:border-primary dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                        </td>
                                        <td class="border-b border-[#eee] py-3 px-2 dark:border-gray-700">
                                            <input type="text" name="informal[0][tempat]" class="w-full rounded border-[1.5px] border-stroke bg-white px-3 py-2 outline-none focus:border-primary dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                        </td>
                                        <td class="border-b border-[#eee] py-3 px-2 dark:border-gray-700">
                                            <input type="text" name="informal[0][tahun]" class="w-full rounded border-[1.5px] border-stroke bg-white px-3 py-2 outline-none focus:border-primary dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                        </td>
                                        <td class="border-b border-[#eee] py-3 px-2 dark:border-gray-700">
                                            <input type="text" name="informal[0][keterangan]" class="w-full rounded border-[1.5px] border-stroke bg-white px-3 py-2 outline-none focus:border-primary dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                        </td>
                                        <td class="border-b border-[#eee] py-3 px-2 dark:border-gray-700 text-center">
                                            <button type="button" class="text-red-500 hover:text-red-700 font-medium btn-hapus-kursus text-sm transition-all">Hapus</button>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <div class="flex flex-col md:flex-row justify-between gap-4 mt-8 pt-4 border-t border-stroke dark:border-gray-700">
                        {{-- Kiri: Tombol Tambah Kursus --}}
                        <button type="button" id="btn-tambah-kursus" class="flex justify-center rounded border border-stroke py-3 px-6 font-medium text-black dark:text-white hover:bg-gray-50 dark:hover:bg-gray-800 dark:border-gray-600 transition-all">
                            + Tambah Kursus
                        </button>

                        {{-- Kanan: Grup Tombol Simpan & Lanjut --}}
                        <div class="flex flex-col md:flex-row gap-3">
                            <button type="submit" class="flex w-full md:w-auto justify-center rounded bg-green-500 py-3 px-8 font-bold text-white transition hover:bg-green-600 shadow-sm">
                                Simpan Pendidikan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Skrip untuk Pendidikan Formal (Hapus Baris)
            const tbodyFormal = document.getElementById('tbody-formal');
            tbodyFormal.addEventListener('click', function(e) {
                if (e.target.classList.contains('btn-hapus-formal')) {
                    // Hanya kosongkan inputannya saja karena ini baris statis (S1, SMA, dll)
                    const inputs = e.target.closest('tr').querySelectorAll('input[type="text"]');
                    inputs.forEach(input => input.value = '');
                }
            });

            // Skrip untuk Pendidikan Informal / Kursus (Tambah & Hapus Baris)
            const btnTambahKursus = document.getElementById('btn-tambah-kursus');
            const tbodyInformal = document.getElementById('tbody-informal');
            let arrayIndex = {{ $karyawan && $karyawan->pendidikans->where('kategori', 'Informal')->count() > 0 ? $karyawan->pendidikans->where('kategori', 'Informal')->count() : 1 }};

            btnTambahKursus.addEventListener('click', function () {
                const barisBaru = `
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition">
                        <td class="border-b border-[#eee] py-3 px-2 dark:border-gray-700">
                            <input type="text" name="informal[${arrayIndex}][nama_institusi]" class="w-full rounded border-[1.5px] border-stroke bg-white px-3 py-2 outline-none focus:border-primary dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </td>
                        <td class="border-b border-[#eee] py-3 px-2 dark:border-gray-700">
                            <input type="text" name="informal[${arrayIndex}][tempat]" class="w-full rounded border-[1.5px] border-stroke bg-white px-3 py-2 outline-none focus:border-primary dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </td>
                        <td class="border-b border-[#eee] py-3 px-2 dark:border-gray-700">
                            <input type="text" name="informal[${arrayIndex}][tahun]" class="w-full rounded border-[1.5px] border-stroke bg-white px-3 py-2 outline-none focus:border-primary dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </td>
                        <td class="border-b border-[#eee] py-3 px-2 dark:border-gray-700">
                            <input type="text" name="informal[${arrayIndex}][keterangan]" class="w-full rounded border-[1.5px] border-stroke bg-white px-3 py-2 outline-none focus:border-primary dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </td>
                        <td class="border-b border-[#eee] py-3 px-2 dark:border-gray-700 text-center">
                            <button type="button" class="text-red-500 hover:text-red-700 font-medium btn-hapus-kursus text-sm transition-all">Hapus</button>
                        </td>
                    </tr>
                `;
                tbodyInformal.insertAdjacentHTML('beforeend', barisBaru);
                arrayIndex++;
            });

            tbodyInformal.addEventListener('click', function(e) {
                if (e.target.classList.contains('btn-hapus-kursus')) {
                    e.target.closest('tr').remove();
                }
            });
        });
    </script>
@endsection