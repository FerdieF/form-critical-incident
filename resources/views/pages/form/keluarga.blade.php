@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Data Susunan Keluarga" />

    <div class="grid grid-cols-1 gap-6">
        @if(session('success'))
            <div class="mb-6 flex w-full rounded border-l-6 border-[#10B981] bg-[#10B981]/10 px-7 py-4 shadow-md dark:bg-[#10B981]/20">
                <div class="w-full">
                    <h5 class="text-lg font-bold text-[#10B981] mb-1">Berhasil!</h5>
                    <p class="text-base text-[#10B981] font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 flex w-full rounded border-l-6 border-[#F87171] bg-[#F87171]/10 px-7 py-4 shadow-md dark:bg-[#F87171]/20">
                <div class="w-full">
                    <h5 class="text-lg font-bold text-[#F87171] mb-1">Terjadi Kesalahan!</h5>
                    <ul class="list-disc list-inside text-sm text-[#F87171] font-medium">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-gray-700 dark:bg-gray-800">
            <div class="border-b border-stroke py-4 px-6.5 dark:border-gray-700">
                <h3 class="font-bold text-black dark:text-white uppercase">
                    II. Susunan Keluarga
                </h3>
            </div>
            
            <form action="{{ route('form.keluarga.store') }}" method="POST">
                @csrf
                <div class="p-6.5">
                    
                    <div class="overflow-x-auto mb-8 rounded-md border border-stroke dark:border-gray-700">
                        <table class="w-full table-auto text-left whitespace-nowrap">
                            <thead>
                                <tr class="bg-gray-100 dark:bg-gray-700 text-black dark:text-white">
                                    <th class="py-3 px-4 font-bold border-b border-stroke dark:border-gray-600">Hubungan</th>
                                    <th class="py-3 px-4 font-bold border-b border-stroke dark:border-gray-600">Nama Lengkap</th>
                                    <th class="py-3 px-4 font-bold border-b border-stroke dark:border-gray-600">L/P</th>
                                    <th class="py-3 px-4 font-bold border-b border-stroke dark:border-gray-600">Tempat Lahir</th>
                                    <th class="py-3 px-4 font-bold border-b border-stroke dark:border-gray-600">Tgl Lahir</th>
                                    <th class="py-3 px-4 font-bold border-b border-stroke dark:border-gray-600">Pendidikan</th>
                                    <th class="py-3 px-4 font-bold border-b border-stroke dark:border-gray-600">Pekerjaan</th>
                                    <th class="py-3 px-4 font-bold border-b border-stroke dark:border-gray-600 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-keluarga">
                                @php
                                    $keluargasList = ($karyawan ?? false) && $karyawan->keluargas->count() > 0 
                                        ? $karyawan->keluargas 
                                        : collect();
                                    
                                    // Tarik status pernikahan dari Identitas Diri
                                    $statusKawin = optional($karyawan)->status_pernikahan ?? 'Belum Kawin';
                                @endphp

                                @if($keluargasList->count() > 0)
                                    @foreach($keluargasList as $index => $kel)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition">
                                        <td class="border-b border-[#eee] py-3 px-2 dark:border-gray-700">
                                            <select name="keluarga[{{ $index }}][hubungan]" class="w-full rounded border border-stroke bg-white px-3 py-2 outline-none focus:border-primary dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                                <option value="">-- Pilih --</option>
                                                {{-- Kunci Opsi Suami/Istri Berdasarkan Status Kawin --}}
                                                @if($statusKawin !== 'Belum Kawin')
                                                    <option value="Suami" {{ $kel->hubungan == 'Suami' ? 'selected' : '' }}>Suami</option>
                                                    <option value="Istri" {{ $kel->hubungan == 'Istri' ? 'selected' : '' }}>Istri</option>
                                                @endif
                                                <option value="Anak" {{ $kel->hubungan == 'Anak' ? 'selected' : '' }}>Anak</option>
                                                <option value="Ayah" {{ $kel->hubungan == 'Ayah' ? 'selected' : '' }}>Ayah</option>
                                                <option value="Ibu" {{ $kel->hubungan == 'Ibu' ? 'selected' : '' }}>Ibu</option>
                                            </select>
                                        </td>
                                        <td class="border-b border-[#eee] py-3 px-2 dark:border-gray-700">
                                            <input type="text" name="keluarga[{{ $index }}][nama]" value="{{ $kel->nama }}" placeholder="Nama" class="w-full rounded border border-stroke bg-white px-3 py-2 outline-none focus:border-primary dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                        </td>
                                        <td class="border-b border-[#eee] py-3 px-2 dark:border-gray-700">
                                            <select name="keluarga[{{ $index }}][jenis_kelamin]" class="w-full rounded border border-stroke bg-white px-3 py-2 outline-none focus:border-primary dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                                <option value="">L/P</option>
                                                <option value="L" {{ $kel->jenis_kelamin == 'L' ? 'selected' : '' }}>L</option>
                                                <option value="P" {{ $kel->jenis_kelamin == 'P' ? 'selected' : '' }}>P</option>
                                            </select>
                                        </td>
                                        <td class="border-b border-[#eee] py-3 px-2 dark:border-gray-700">
                                            <input type="text" name="keluarga[{{ $index }}][tempat_lahir]" value="{{ $kel->tempat_lahir }}" placeholder="Tempat" class="w-full rounded border border-stroke bg-white px-3 py-2 outline-none focus:border-primary dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                        </td>
                                        <td class="border-b border-[#eee] py-3 px-2 dark:border-gray-700">
                                            <input type="date" name="keluarga[{{ $index }}][tanggal_lahir]" value="{{ $kel->tanggal_lahir }}" class="w-full rounded border border-stroke bg-white px-3 py-2 outline-none focus:border-primary dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                        </td>
                                        <td class="border-b border-[#eee] py-3 px-2 dark:border-gray-700">
                                            <input type="text" name="keluarga[{{ $index }}][pendidikan]" value="{{ $kel->pendidikan }}" placeholder="Pendidikan" class="w-full rounded border border-stroke bg-white px-3 py-2 outline-none focus:border-primary dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                        </td>
                                        <td class="border-b border-[#eee] py-3 px-2 dark:border-gray-700">
                                            <input type="text" name="keluarga[{{ $index }}][pekerjaan]" value="{{ $kel->pekerjaan }}" placeholder="Pekerjaan" class="w-full rounded border border-stroke bg-white px-3 py-2 outline-none focus:border-primary dark:border-gray-600 dark:bg-gray-700 dark:text-white">
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
                                            <select name="keluarga[0][hubungan]" class="w-full rounded border border-stroke bg-white px-3 py-2 outline-none focus:border-primary dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                                <option value="">-- Pilih --</option>
                                                @if($statusKawin !== 'Belum Kawin')
                                                    <option value="Suami">Suami</option>
                                                    <option value="Istri">Istri</option>
                                                @endif
                                                <option value="Anak">Anak</option>
                                                <option value="Ayah">Ayah</option>
                                                <option value="Ibu">Ibu</option>
                                            </select>
                                        </td>
                                        <td class="border-b border-[#eee] py-3 px-2 dark:border-gray-700">
                                            <input type="text" name="keluarga[0][nama]" placeholder="Nama" class="w-full rounded border border-stroke bg-white px-3 py-2 outline-none focus:border-primary dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                        </td>
                                        <td class="border-b border-[#eee] py-3 px-2 dark:border-gray-700">
                                            <select name="keluarga[0][jenis_kelamin]" class="w-full rounded border border-stroke bg-white px-3 py-2 outline-none focus:border-primary dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                                <option value="">L/P</option>
                                                <option value="L">L</option>
                                                <option value="P">P</option>
                                            </select>
                                        </td>
                                        <td class="border-b border-[#eee] py-3 px-2 dark:border-gray-700">
                                            <input type="text" name="keluarga[0][tempat_lahir]" placeholder="Tempat" class="w-full rounded border border-stroke bg-white px-3 py-2 outline-none focus:border-primary dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                        </td>
                                        <td class="border-b border-[#eee] py-3 px-2 dark:border-gray-700">
                                            <input type="date" name="keluarga[0][tanggal_lahir]" class="w-full rounded border border-stroke bg-white px-3 py-2 outline-none focus:border-primary dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                        </td>
                                        <td class="border-b border-[#eee] py-3 px-2 dark:border-gray-700">
                                            <input type="text" name="keluarga[0][pendidikan]" placeholder="Pendidikan" class="w-full rounded border border-stroke bg-white px-3 py-2 outline-none focus:border-primary dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                        </td>
                                        <td class="border-b border-[#eee] py-3 px-2 dark:border-gray-700">
                                            <input type="text" name="keluarga[0][pekerjaan]" placeholder="Pekerjaan" class="w-full rounded border border-stroke bg-white px-3 py-2 outline-none focus:border-primary dark:border-gray-600 dark:bg-gray-700 dark:text-white">
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
                        <button type="button" id="btn-tambah-keluarga" class="flex justify-center rounded border border-stroke py-3 px-6 font-medium text-black dark:text-white hover:bg-gray-50 dark:hover:bg-gray-700 dark:border-gray-600 transition-all">
                            + Tambah Anggota Keluarga
                        </button>

                        <button type="submit" class="flex w-full md:w-auto justify-center rounded bg-green-500 py-3 px-8 font-bold text-white transition hover:bg-green-600 shadow-sm">
                            Simpan & Lanjut ke Pendidikan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const btnTambah = document.getElementById('btn-tambah-keluarga');
            const tbody = document.getElementById('tbody-keluarga');
            let arrayIndex = {{ $keluargasList->count() > 0 ? $keluargasList->count() : 1 }};
            
            // Logika Dropdown Hubungan yang disisipkan ke Javascript
            let opsiHubungan = `<option value="">-- Pilih --</option>`;
            @if($statusKawin !== 'Belum Kawin')
                opsiHubungan += `<option value="Suami">Suami</option><option value="Istri">Istri</option>`;
            @endif
            opsiHubungan += `<option value="Anak">Anak</option><option value="Ayah">Ayah</option><option value="Ibu">Ibu</option>`;

            btnTambah.addEventListener('click', function () {
                const barisBaru = `
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition">
                        <td class="border-b border-[#eee] py-3 px-2 dark:border-gray-700">
                            <select name="keluarga[${arrayIndex}][hubungan]" class="w-full rounded border border-stroke bg-white px-3 py-2 outline-none focus:border-primary dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                ${opsiHubungan}
                            </select>
                        </td>
                        <td class="border-b border-[#eee] py-3 px-2 dark:border-gray-700">
                            <input type="text" name="keluarga[${arrayIndex}][nama]" placeholder="Nama" class="w-full rounded border border-stroke bg-white px-3 py-2 outline-none focus:border-primary dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </td>
                        <td class="border-b border-[#eee] py-3 px-2 dark:border-gray-700">
                            <select name="keluarga[${arrayIndex}][jenis_kelamin]" class="w-full rounded border border-stroke bg-white px-3 py-2 outline-none focus:border-primary dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                                <option value="">L/P</option>
                                <option value="L">L</option>
                                <option value="P">P</option>
                            </select>
                        </td>
                        <td class="border-b border-[#eee] py-3 px-2 dark:border-gray-700">
                            <input type="text" name="keluarga[${arrayIndex}][tempat_lahir]" placeholder="Tempat" class="w-full rounded border border-stroke bg-white px-3 py-2 outline-none focus:border-primary dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </td>
                        <td class="border-b border-[#eee] py-3 px-2 dark:border-gray-700">
                            <input type="date" name="keluarga[${arrayIndex}][tanggal_lahir]" class="w-full rounded border border-stroke bg-white px-3 py-2 outline-none focus:border-primary dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </td>
                        <td class="border-b border-[#eee] py-3 px-2 dark:border-gray-700">
                            <input type="text" name="keluarga[${arrayIndex}][pendidikan]" placeholder="Pendidikan" class="w-full rounded border border-stroke bg-white px-3 py-2 outline-none focus:border-primary dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        </td>
                        <td class="border-b border-[#eee] py-3 px-2 dark:border-gray-700">
                            <input type="text" name="keluarga[${arrayIndex}][pekerjaan]" placeholder="Pekerjaan" class="w-full rounded border border-stroke bg-white px-3 py-2 outline-none focus:border-primary dark:border-gray-600 dark:bg-gray-700 dark:text-white">
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