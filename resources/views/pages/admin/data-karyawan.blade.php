@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Daftar Asesmen Peserta" />

    <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-gray-700 dark:bg-gray-800">
        <div class="max-w-full overflow-x-auto p-4">
            <table class="w-full table-auto border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-left dark:bg-gray-700">
                        <th class="py-4 px-4 font-medium text-black dark:text-white">Nama Karyawan</th>
                        <th class="py-4 px-4 font-medium text-black dark:text-white">NIK SAP</th>
                        <th class="py-4 px-4 font-medium text-black dark:text-white">Jabatan</th>
                        <th class="py-4 px-4 font-medium text-black dark:text-white">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                        @foreach($users as $user)
                        <tr class="border-b border-stroke dark:border-gray-700">
                            {{-- 1. Kolom Nama --}}
                            <td class="py-4 px-4">
                                <p class="font-bold !text-black dark:!text-white">
                                    {{ optional($user->karyawan)->nama_lengkap ?? $user->name }}
                                </p>
                                <p class="text-xs !text-gray-500 dark:!text-gray-400">
                                    {{ optional($user->karyawan)->perusahaan ?? 'Belum ada data' }}
                                </p>
                            </td>

                            {{-- 2. Kolom NIK SAP --}}
                            <td class="py-4 px-4 font-medium !text-black dark:!text-white">
                                {{ $user->nik_sap }}
                            </td>

                            {{-- 3. Kolom Jabatan / Status --}}
                            <td class="py-4 px-4">
                                @if($user->karyawan)
                                    {{-- Jika sudah ngisi form, tampilkan jabatan --}}
                                    <p class="font-medium !text-black dark:!text-white">
                                        {{ $user->karyawan->jabatan ?? '-' }}
                                    </p>
                                    <p class="text-xs !text-gray-500 dark:!text-gray-400">
                                        Gol: {{ $user->karyawan->golongan ?? '-' }}
                                    </p>
                                @else
                                    {{-- Jika BELUM ngisi form, tampilkan badge merah --}}
                                    <span class="inline-flex rounded-full bg-danger/10 px-3 py-1 text-xs font-medium text-danger dark:!text-red-400 border border-danger/20">
                                        Belum Mengisi Form
                                    </span>
                                @endif
                            </td>

                            {{-- 4. Kolom Aksi --}}
                            <td class="py-4 px-4">
                                @if($user->karyawan)
                                    {{-- Tombol aktif jika data ada --}}
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.karyawan.show', $user->karyawan->id) }}" class="inline-flex items-center justify-center rounded border border-primary px-4 py-1 text-sm font-medium text-primary hover:bg-primary hover:text-white dark:border-primary dark:text-blue-400 dark:hover:text-white transition">
                                            Lihat Detail
                                        </a>
                                        <a href="{{ route('admin.print_individu_pdf', $user->karyawan->id) }}" target="_blank" class="inline-flex items-center justify-center rounded border border-emerald-500 px-4 py-1 text-sm font-medium text-emerald-500 hover:bg-emerald-500 hover:text-white dark:border-emerald-400 dark:text-emerald-400 dark:hover:text-white transition">
                                            Cetak
                                        </a>
                                    </div>
                                @else
                                    {{-- Tombol mati/disabled jika data belum ada --}}
                                    <button disabled class="inline-flex items-center justify-center rounded border border-gray-300 bg-gray-100 px-4 py-1 text-sm font-medium text-gray-400 cursor-not-allowed dark:border-gray-600 dark:bg-gray-700 dark:text-gray-500">
                                        Menunggu...
                                    </button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
            </table>
        </div>
    </div>
    
@endsection