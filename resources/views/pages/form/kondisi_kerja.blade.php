@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Data Kondisi Kerja" />

    {{-- STYLE UNTUK MEMAKSA WARNA BIRU SAAT CHECKED --}}
    <style>
        /* 1. Memaksa warna biru saat tombol dipilih (Light & Dark Mode) */
        input[type="radio"].custom-radio:checked + .radio-box {
            background-color: #3C50E0 !important;
            border-color: #3C50E0 !important;
            color: #ffffff !important;
        }

        /* 2. MEMAKSA DARK MODE JIKA TAILWIND MACET */
        /* Saat html/body memiliki class .dark, paksa elemen di dalamnya berubah warna */
        .dark .bg-white {
            background-color: #24303F !important; /* Warna bg-boxdark TailAdmin */
            border-color: #313D4A !important; /* Warna garis gelap */
        }

        .dark .text-black, 
        .dark label,
        .dark h3 {
            color: #ffffff !important; /* Paksa teks jadi putih */
        }

        .dark .radio-box {
            border-color: #313D4A !important;
            color: #A6A8B6 !important; /* Warna teks abu-abu terang untuk tombol tidak aktif */
        }

        .dark textarea {
            background-color: #1D2A39 !important; /* Warna bg input gelap */
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
                    VI. KONDISI KERJA ({{ $karyawan->nama_lengkap ?? '' }})
                </h3>
            </div>
            
            <form action="{{ route('form.kondisi_kerja.store') }}" method="POST">
                @csrf
                <div class="p-6.5">
                    
                    @php $kondisi = $karyawan->kondisiKerja ?? null; @endphp
                    
                    {{-- PERTANYAAN 1 --}}
                    <div class="mb-8">
                        <label class="mb-3 block font-medium text-black dark:text-white">1. Apakah penghasilan yang Anda terima saat ini sesuai dengan pekerjaan yang Anda lakukan?</label>
                        <div class="flex gap-4 mb-3">
                            <label class="cursor-pointer">
                                <input type="radio" name="penghasilan_sesuai" value="Cukup" class="custom-radio sr-only" required {{ ($kondisi->penghasilan_sesuai ?? '') == 'Cukup' ? 'checked' : '' }} />
                                <div class="radio-box text-black dark:text-white rounded-md border border-stroke px-6 py-2 transition-all hover:bg-gray-2 dark:border-strokedark dark:hover:bg-meta-4">
                                    Cukup
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="penghasilan_sesuai" value="Kurang" class="custom-radio sr-only" {{ ($kondisi->penghasilan_sesuai ?? '') == 'Kurang' ? 'checked' : '' }} />
                                <div class="radio-box text-black dark:text-white rounded-md border border-stroke px-6 py-2 transition-all hover:bg-gray-2 dark:border-strokedark dark:hover:bg-meta-4">
                                    Kurang
                                </div>
                            </label>
                        </div>
                        <textarea name="penghasilan_penjelasan" placeholder="Jelaskan pendapat Anda..." rows="2" class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 outline-none focus:border-primary dark:border-form-strokedark dark:bg-form-input dark:text-white">{{ $kondisi->penghasilan_penjelasan ?? '' }}</textarea>
                    </div>

                    {{-- PERTANYAAN 2 --}}
                    <div class="mb-8">
                        <label class="mb-3 block font-medium text-black dark:text-white">2. Adakah jaminan-jaminan lain yang belum diberikan oleh perusahaan yang Anda anggap penting?</label>
                        <div class="flex gap-4 mb-3">
                            <label class="cursor-pointer">
                                <input type="radio" name="jaminan_belum_diberikan" value="Ada" class="custom-radio sr-only" required {{ ($kondisi->jaminan_belum_diberikan ?? '') == 'Ada' ? 'checked' : '' }} />
                                <div class="radio-box text-black dark:text-white rounded-md border border-stroke px-6 py-2 transition-all hover:bg-gray-2 dark:border-strokedark dark:hover:bg-meta-4">
                                    Ada
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="jaminan_belum_diberikan" value="Tidak Ada" class="custom-radio sr-only" {{ ($kondisi->jaminan_belum_diberikan ?? '') == 'Tidak Ada' ? 'checked' : '' }} />
                                <div class="radio-box text-black dark:text-white rounded-md border border-stroke px-6 py-2 transition-all hover:bg-gray-2 dark:border-strokedark dark:hover:bg-meta-4">
                                    Tidak Ada
                                </div>
                            </label>
                        </div>
                        <textarea name="jaminan_penjelasan" placeholder="Jelaskan pendapat Anda..." rows="2" class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 outline-none focus:border-primary dark:border-form-strokedark dark:bg-form-input dark:text-white">{{ $kondisi->jaminan_penjelasan ?? '' }}</textarea>
                    </div>

                    {{-- PERTANYAAN 3 --}}
                    <div class="mb-8">
                        <label class="mb-3 block font-medium text-black dark:text-white">3. Bagaimanakah kondisi kerja Anda (tempat, suasana, tugas) saat ini?</label>
                        <div class="flex flex-wrap gap-4 mb-3">
                            <label class="cursor-pointer">
                                <input type="radio" name="kondisi_kerja_saat_ini" value="Baik" class="custom-radio sr-only" required {{ ($kondisi->kondisi_kerja_saat_ini ?? '') == 'Baik' ? 'checked' : '' }} />
                                <div class="radio-box text-black dark:text-white rounded-md border border-stroke px-6 py-2 transition-all hover:bg-gray-2 dark:border-strokedark dark:hover:bg-meta-4">
                                    Baik
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="kondisi_kerja_saat_ini" value="Cukup Baik" class="custom-radio sr-only" {{ ($kondisi->kondisi_kerja_saat_ini ?? '') == 'Cukup Baik' ? 'checked' : '' }} />
                                <div class="radio-box text-black dark:text-white rounded-md border border-stroke px-6 py-2 transition-all hover:bg-gray-2 dark:border-strokedark dark:hover:bg-meta-4">
                                    Cukup Baik
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="kondisi_kerja_saat_ini" value="Perlu Perbaikan" class="custom-radio sr-only" {{ ($kondisi->kondisi_kerja_saat_ini ?? '') == 'Perlu Perbaikan' ? 'checked' : '' }} />
                                <div class="radio-box text-black dark:text-white rounded-md border border-stroke px-6 py-2 transition-all hover:bg-gray-2 dark:border-strokedark dark:hover:bg-meta-4">
                                    Perlu Perbaikan
                                </div>
                            </label>
                        </div>
                        <textarea name="kondisi_kerja_penjelasan" placeholder="Ceritakan kondisi yang dimaksud & usulan perbaikan..." rows="2" class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 outline-none focus:border-primary dark:border-form-strokedark dark:bg-form-input dark:text-white">{{ $kondisi->kondisi_kerja_penjelasan ?? '' }}</textarea>
                    </div>

                    {{-- PERTANYAAN 4 --}}
                    <div class="mb-8">
                        <label class="mb-3 block font-medium text-black dark:text-white">4. Bagaimanakah penilaian PRESTASI yang diberikan perusahaan terhadap hasil kerja Anda?</label>
                        <div class="flex flex-wrap gap-4">
                            <label class="cursor-pointer">
                                <input type="radio" name="penilaian_prestasi" value="Cukup Sesuai" class="custom-radio sr-only" required {{ ($kondisi->penilaian_prestasi ?? '') == 'Cukup Sesuai' ? 'checked' : '' }} />
                                <div class="radio-box text-black dark:text-white rounded-md border border-stroke px-6 py-2 transition-all hover:bg-gray-2 dark:border-strokedark dark:hover:bg-meta-4">
                                    Cukup Sesuai
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="penilaian_prestasi" value="Kurang" class="custom-radio sr-only" {{ ($kondisi->penilaian_prestasi ?? '') == 'Kurang' ? 'checked' : '' }} />
                                <div class="radio-box text-black dark:text-white rounded-md border border-stroke px-6 py-2 transition-all hover:bg-gray-2 dark:border-strokedark dark:hover:bg-meta-4">
                                    Kurang
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="penilaian_prestasi" value="Kurang Sekali" class="custom-radio sr-only" {{ ($kondisi->penilaian_prestasi ?? '') == 'Kurang Sekali' ? 'checked' : '' }} />
                                <div class="radio-box text-black dark:text-white rounded-md border border-stroke px-6 py-2 transition-all hover:bg-gray-2 dark:border-strokedark dark:hover:bg-meta-4">
                                    Kurang Sekali
                                </div>
                            </label>
                        </div>
                    </div>

                    {{-- PERTANYAAN 5 --}}
                    <div class="mb-8">
                        <label class="mb-3 block font-medium text-black dark:text-white">5. Ada beberapa aspek/situasi yang membuat Anda dapat optimal dalam bekerja. Jelaskan aspek apa saja yang mendukung optimalisasi tersebut?</label>
                        <textarea name="aspek_optimalisasi" rows="3" class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 outline-none focus:border-primary dark:border-form-strokedark dark:bg-form-input dark:text-white">{{ $kondisi->aspek_optimalisasi ?? '' }}</textarea>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="submit" class="flex w-full md:w-1/3 justify-center rounded bg-green-500 p-3 font-medium text-white transition hover:bg-green-600">
                            Simpan Kondisi Kerja
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection