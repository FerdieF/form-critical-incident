@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Data Riwayat Pekerjaan" />

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
                    IV. Riwayat Pekerjaan
                </h3>
            </div>
            
            <form action="{{ route('form.pekerjaan.store') }}" method="POST">
                @csrf
                <div class="p-6.5">
                    
                    <p class="mb-6 text-sm text-gray-500 dark:text-gray-400">
                        Uraikan dengan singkat pekerjaan Anda selama ini (dimulai dari posisi terakhir):
                    </p>

                    <div class="overflow-x-auto mb-8 rounded-md border border-stroke dark:border-gray-700">
                        <table class="w-full table-auto text-left">
                            <thead>
                                <tr class="bg-gray-100 dark:bg-gray-700 text-black dark:text-white">
                                    <th class="py-3 px-4 font-bold border-b border-stroke dark:border-gray-600 min-w-[150px]">Jabatan</th>
                                    <th class="py-3 px-4 font-bold border-b border-stroke dark:border-gray-600 min-w-[200px]">Bln/Thn s/d Bln/Thn</th>
                                    <th class="py-3 px-4 font-bold border-b border-stroke dark:border-gray-600 min-w-[200px]">Perusahaan</th>
                                    <th class="py-3 px-4 font-bold border-b border-stroke dark:border-gray-600 min-w-[150px]">Unit / Kebun</th>
                                    <th class="py-3 px-4 font-bold border-b border-stroke dark:border-gray-600 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-pekerjaan">
                                @php
                                    $pekerjaanList = ($karyawan ?? false) && $karyawan->pengalamanKerjas->count() > 0 
                                        ? $karyawan->pengalamanKerjas 
                                        : collect();
                                @endphp

                                @if($pekerjaanList->count() > 0)
                                    @foreach($pekerjaanList as $index => $kerja)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition">
                                        <td class="border-b border-[#eee] py-3 px-2 dark:border-gray-700">
                                            <input type="text" name="pekerjaan[{{ $index }}][jabatan]" value="{{ $kerja->jabatan }}" class="w-full rounded border border-stroke bg-white px-3 py-2 outline-none focus:border-primary dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                        </td>
                                        <td class="border-b border-[#eee] py-3 px-2 dark:border-gray-700">
                                            <input type="text" name="pekerjaan[{{ $index }}][masa_kerja]" value="{{ $kerja->masa_kerja }}" class="w-full rounded border border-stroke bg-white px-3 py-2 outline-none focus:border-primary dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                        </td>
                                        <td class="border-b border-[#eee] py-3 px-2 dark:border-gray-700">
                                            {{-- Perhatikan "perusahaan" di sini --}}
                                            <input type="text" name="pekerjaan[{{ $index }}][perusahaan]" value="{{ $kerja->perusahaan }}" class="w-full rounded border border-stroke bg-white px-3 py-2 outline-none focus:border-primary dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                        </td>
                                        <td class="border-b border-[#eee] py-3 px-2 dark:border-gray-700">
                                            <input type="text" name="pekerjaan[{{ $index }}][bagian]" value="{{ $kerja->bagian }}" class="w-full rounded border border-stroke bg-white px-3 py-2 outline-none focus:border-primary dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                        </td>
                                        <td class="border-b border-[#eee] py-3 px-2 dark:border-gray-700 text-center">
                                            <button type="button" class="text-red-500 hover:text-red-700 font-medium btn-hapus text-sm transition-all">Hapus</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    {{-- Baris Kosong Default --}}
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition">
                                        <td class="border-b border-[#eee] py-3 px-2 dark:border-gray-700">
                                            <input type="text" name="pekerjaan[0][jabatan]" class="w-full rounded border border-stroke bg-white px-3 py-2 outline-none focus:border-primary dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                        </td>
                                        <td class="border-b border-[#eee] py-3 px-2 dark:border-gray-700">
                                            <input type="text" name="pekerjaan[0][masa_kerja]" placeholder="Jan 2020 - Mar 2023" class="w-full rounded border border-stroke bg-white px-3 py-2 outline-none focus:border-primary dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                        </td>
                                        <td class="border-b border-[#eee] py-3 px-2 dark:border-gray-700">
                                            <input type="text" name="pekerjaan[0][perusahaan]" class="w-full rounded border border-stroke bg-white px-3 py-2 outline-none focus:border-primary dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                        </td>
                                        <td class="border-b border-[#eee] py-3 px-2 dark:border-gray-700">
                                            <input type="text" name="pekerjaan[0][bagian]" class="w-full rounded border border-stroke bg-white px-3 py-2 outline-none focus:border-primary dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                        </td>
                                        <td class="border-b border-[#eee] py-3 px-2 dark:border-gray-700 text-center">
                                            <button type="button" class="text-red-500 hover:text-red-700 font-medium btn-hapus text-sm transition-all">Hapus</button>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <div class="flex flex-col md:flex-row justify-between gap-4 mt-8 pt-4 border-t border-stroke dark:border-gray-700">
                        <button type="button" id="btn-tambah-pekerjaan" class="flex justify-center rounded border border-stroke py-3 px-6 font-medium text-black dark:text-white hover:bg-gray-50 dark:hover:bg-gray-700 dark:border-gray-600 transition-all">
                            + Tambah Pengalaman
                        </button>

                        <div class="flex flex-col md:flex-row gap-3">
                            <button type="submit" class="flex w-full md:w-auto justify-center rounded bg-green-500 py-3 px-8 font-bold text-white transition hover:bg-green-600 shadow-sm">
                                Simpan Riwayat Pekerjaan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const btnTambah = document.getElementById('btn-tambah-pekerjaan');
            const tbody = document.getElementById('tbody-pekerjaan');
            let arrayIndex = {{ $pekerjaanList->count() > 0 ? $pekerjaanList->count() : 1 }};

            btnTambah.addEventListener('click', function () {
                const barisBaru = `
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition">
                        <td class="border-b border-[#eee] py-3 px-2 dark:border-gray-700">
                            <input type="text" name="pekerjaan[${arrayIndex}][jabatan]" class="w-full rounded border border-stroke bg-white px-3 py-2 outline-none focus:border-primary dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </td>
                        <td class="border-b border-[#eee] py-3 px-2 dark:border-gray-700">
                            <input type="text" name="pekerjaan[${arrayIndex}][masa_kerja]" placeholder="Jan 2020 - Mar 2023" class="w-full rounded border border-stroke bg-white px-3 py-2 outline-none focus:border-primary dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </td>
                        <td class="border-b border-[#eee] py-3 px-2 dark:border-gray-700">
                            <input type="text" name="pekerjaan[${arrayIndex}][perusahaan]" class="w-full rounded border border-stroke bg-white px-3 py-2 outline-none focus:border-primary dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </td>
                        <td class="border-b border-[#eee] py-3 px-2 dark:border-gray-700">
                            <input type="text" name="pekerjaan[${arrayIndex}][bagian]" class="w-full rounded border border-stroke bg-white px-3 py-2 outline-none focus:border-primary dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </td>
                        <td class="border-b border-[#eee] py-3 px-2 dark:border-gray-700 text-center">
                            <button type="button" class="text-red-500 hover:text-red-700 font-medium btn-hapus text-sm transition-all">Hapus</button>
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