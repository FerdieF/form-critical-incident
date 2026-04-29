@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Form Critical Incident" />

    {{-- TAMBAHKAN STYLE INI UNTUK MEMAKSA DARK MODE (JALUR DARURAT) --}}
    <style>
        .dark .bg-white {
            background-color: #24303F !important; /* Warna kontainer utama */
            border-color: #313D4A !important;
        }

        /* Khusus untuk kotak pembungkus tiap Insiden */
        .dark .bg-gray-50 {
            background-color: #313D4A !important; 
            border-color: #313D4A !important;
        }

        .dark .text-black, 
        .dark h3, 
        .dark h4, 
        .dark label,
        .dark p {
            color: #ffffff !important; /* Paksa teks jadi putih */
        }

        .dark textarea,
        .dark input[type="text"],
        .dark input[type="date"],
        .dark input[type="hidden"] {
            background-color: #1D2A39 !important; /* Warna background input & textarea */
            border-color: #313D4A !important;
            color: #ffffff !important;
        }
    </style>

    <div class="grid grid-cols-1 gap-6">
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
                    DATA CRITICAL INCIDENT ({{ $karyawan->nama_lengkap ?? '' }})
                </h3>
            </div>
            
            <form action="{{ route('form.critical_incident.store') }}" method="POST">
                @csrf
                <div class="p-6.5">
                    @php 
                        $incidents = isset($karyawan) ? $karyawan->criticalIncidents : collect();
                        $today = \Illuminate\Support\Carbon::now('Asia/Jakarta')->toDateString();
                        $formatDateInput = function ($value) {
                            if (blank($value)) {
                                return '';
                            }

                            try {
                                return \Illuminate\Support\Carbon::parse($value)->toDateString();
                            } catch (\Throwable $exception) {
                                return '';
                            }
                        };
                        
                        $jenis_insiden = [
                            'Sukses' => '1. Pengalaman SUKSES Besar (Paling Bermakna)', 
                            'Gagal' => '2. Pengalaman KEGAGALAN Besar (Paling Mengecewakan)'
                        ]; 
                        $index = 0;
                    @endphp

                    @foreach($jenis_insiden as $jenis => $judul)
                        @php
                            $dataLama = $incidents->firstWhere('jenis_insiden', $jenis);
                        @endphp

                        {{-- PERBAIKAN: Hapus style inline dan ganti pakai bg-gray-50 --}}
                        <div class="mb-10 p-6 rounded-md border border-stroke dark:border-strokedark shadow-sm bg-gray-50 dark:bg-meta-4">
                            @php
                                $waktuKejadian = $formatDateInput($dataLama->waktu_kejadian ?? null);
                            @endphp
                            
                            <h4 class="font-bold text-lg text-black dark:text-white mb-2">{{ $judul }}</h4>
                            <p class="mb-6 text-sm text-black dark:text-white opacity-80">
                                Ceritakan kejadian dalam pekerjaan (selama 2 tahun terakhir) yang merupakan suatu {{ strtolower(explode(' ', $judul)[2]) }} besar bagi Anda.
                            </p>
                            
                            <input type="hidden" name="insiden[{{ $index }}][jenis_insiden]" value="{{ $jenis }}">

                            <div class="flex flex-col gap-5.5 sm:flex-row mb-6">
                                <div class="w-full sm:w-1/2">
                                    <label class="mb-2.5 block text-black dark:text-white font-medium">Topik Kejadian</label>
                                    <input type="text" name="insiden[{{ $index }}][topik]" 
                                        value="{{ $dataLama->topik ?? '' }}" 
                                        placeholder="Contoh: Pencapaian Target" 
                                        class="w-full rounded border-[1.5px] border-stroke bg-white px-5 py-3 outline-none focus:border-primary dark:border-strokedark dark:bg-boxdark dark:text-white" />
                                </div>
                                <div class="w-full sm:w-1/2">
                                    <label class="mb-2.5 block text-black dark:text-white font-medium">Waktu Kejadian</label>
                                    <input type="date" name="insiden[{{ $index }}][waktu_kejadian]" 
                                        value="{{ $waktuKejadian }}"
                                        max="{{ $today }}"
                                        class="w-full rounded border-[1.5px] border-stroke bg-white px-5 py-3 outline-none focus:border-primary dark:border-strokedark dark:bg-boxdark dark:text-white" />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-4">
                                <div>
                                    <label class="mb-2 block text-black dark:text-white font-medium text-sm">Kejadiannya:</label>
                                    <textarea name="insiden[{{ $index }}][kejadian]" rows="3" class="w-full rounded border-[1.5px] border-stroke bg-white px-5 py-3 outline-none focus:border-primary dark:border-strokedark dark:bg-boxdark dark:text-white">{{ $dataLama->kejadian ?? '' }}</textarea>
                                </div>

                                <div>
                                    <label class="mb-2 block text-black dark:text-white font-medium text-sm">Situasinya:</label>
                                    <textarea name="insiden[{{ $index }}][situasi]" rows="2" class="w-full rounded border-[1.5px] border-stroke bg-white px-5 py-3 outline-none focus:border-primary dark:border-strokedark dark:bg-boxdark dark:text-white">{{ $dataLama->situasi ?? '' }}</textarea>
                                </div>

                                <div>
                                    <label class="mb-2 block text-black dark:text-white font-medium text-sm">Para Pelaku:</label>
                                    <textarea name="insiden[{{ $index }}][pelaku]" rows="2" class="w-full rounded border-[1.5px] border-stroke bg-white px-5 py-3 outline-none focus:border-primary dark:border-strokedark dark:bg-boxdark dark:text-white">{{ $dataLama->pelaku ?? '' }}</textarea>
                                </div>

                                <div>
                                    <label class="mb-2 block text-black dark:text-white font-medium text-sm">Pikiran, Perasaan, Keinginan:</label>
                                    <textarea name="insiden[{{ $index }}][pikiran_perasaan]" rows="2" class="w-full rounded border-[1.5px] border-stroke bg-white px-5 py-3 outline-none focus:border-primary dark:border-strokedark dark:bg-boxdark dark:text-white">{{ $dataLama->pikiran_perasaan ?? '' }}</textarea>
                                </div>

                                <div>
                                    <label class="mb-2 block text-black dark:text-white font-medium text-sm">Perilaku:</label>
                                    <textarea name="insiden[{{ $index }}][perilaku]" rows="2" class="w-full rounded border-[1.5px] border-stroke bg-white px-5 py-3 outline-none focus:border-primary dark:border-strokedark dark:bg-boxdark dark:text-white">{{ $dataLama->perilaku ?? '' }}</textarea>
                                </div>

                                <div>
                                    <label class="mb-2 block text-black dark:text-white font-medium text-sm">Hasilnya:</label>
                                    <textarea name="insiden[{{ $index }}][hasil]" rows="2" class="w-full rounded border-[1.5px] border-stroke bg-white px-5 py-3 outline-none focus:border-primary dark:border-strokedark dark:bg-boxdark dark:text-white">{{ $dataLama->hasil ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>
                        @php $index++; @endphp
                    @endforeach

                    <div class="mt-8 flex justify-end">
                        <button type="submit" class="flex w-full md:w-1/3 justify-center rounded bg-green-500 p-3 font-medium text-white transition hover:bg-green-600">
                            Simpan Data Critical Incident
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
