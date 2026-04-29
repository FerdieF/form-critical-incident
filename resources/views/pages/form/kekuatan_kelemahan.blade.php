@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Data Kekuatan dan Kelemahan" />

    {{-- TAMBAHKAN STYLE INI UNTUK MEMAKSA DARK MODE TANPA COMPILE TAILWIND --}}
    <style>
        .dark .bg-white {
            background-color: #24303F !important; /* Warna kontainer utama */
            border-color: #313D4A !important;
        }

        .dark .text-black, 
        .dark h3, 
        .dark label {
            color: #ffffff !important; /* Paksa teks jadi putih */
        }

        .dark textarea {
            background-color: #1D2A39 !important; /* Warna background textarea */
            border-color: #313D4A !important;
            color: #ffffff !important;
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
                <h3 class="font-medium text-black dark:text-white dark:text-white">
                    VIII. KEKUATAN DAN KELEMAHAN ({{ $karyawan->nama_lengkap ?? '' }})
                </h3>
            </div>
            
            <form action="{{ route('form.kekuatan_kelemahan.store') }}" method="POST">
                @csrf
                <div class="p-6.5">
                    
                    {{-- Variabel pembantu untuk data Kekuatan & Kelemahan --}}
                    @php $kk = $karyawan->kekuatanKelemahan ?? null; @endphp

                    <div class="mb-6">
                        <label class="mb-2.5 block font-medium text-black dark:text-white">Apakah yang menjadi kekuatan (Strong Point) Anda?</label>
                        <textarea name="kekuatan" rows="4" placeholder="Sebutkan kekuatan utama Anda..." class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 outline-none focus:border-primary dark:border-form-strokedark dark:bg-form-input dark:text-white">{{ $kk->kekuatan ?? '' }}</textarea>
                    </div>

                    <div class="mb-8">
                        <label class="mb-2.5 block font-medium text-black dark:text-white">Apakah yang menjadi kelemahan (Weak Point) Anda?</label>
                        <textarea name="kelemahan" rows="4" placeholder="Sebutkan kelemahan Anda dan bagaimana cara Anda mengatasinya..." class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 outline-none focus:border-primary dark:border-form-strokedark dark:bg-form-input dark:text-white">{{ $kk->kelemahan ?? '' }}</textarea>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="submit" class="flex w-full md:w-1/3 justify-center rounded p-3 font-medium text-white transition hover:opacity-90" style="background-color: #3C50E0;">
                            Simpan Kekuatan & Kelemahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection