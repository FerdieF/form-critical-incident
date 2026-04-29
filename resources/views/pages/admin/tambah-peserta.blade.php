@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Tambah Akun Peserta" />

    <div class="grid grid-cols-1 gap-9 sm:grid-cols-2">
        <div class="flex flex-col gap-9">
            
            {{-- Alert Sukses --}}
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

            {{-- Alert Error (Misal NIK SAP ganda) --}}
            @if($errors->any())
                <div class="flex w-full rounded-sm border-l-6 border-[#F87171] bg-[#F87171]/10 px-7 py-4 shadow-md dark:bg-[#F87171]/20">
                    <div class="w-full">
                        <h5 class="text-lg font-bold text-[#F87171] mb-1">Terjadi Kesalahan!</h5>
                        <ul class="list-disc list-inside text-base text-[#F87171] font-medium">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-gray-700 dark:bg-gray-800">
                <div class="border-b border-stroke py-4 px-6.5 dark:border-gray-700">
                    <h3 class="font-bold text-black dark:text-white">
                        Form Pendaftaran Akun Peserta
                    </h3>
                </div>
                
                <form action="{{ route('admin.peserta.store') }}" method="POST">
                    @csrf
                    <div class="p-6.5 space-y-6">
                        
                        {{-- Nama Panggilan --}}
                        <div>
                            <label class="mb-2.5 block text-black dark:text-white font-medium">
                                Nama Panggilan / Tampilan <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" placeholder="Masukkan nama peserta" required
                                class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-blue-500 active:border-blue-500 disabled:cursor-default disabled:bg-whiter dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:focus:border-blue-500" />
                            <p class="text-xs text-gray-500 mt-1">Nama ini hanya untuk sapaan di dashboard sebelum peserta mengisi form lengkap.</p>
                        </div>

                        {{-- NIK SAP --}}
                        <div>
                            <label class="mb-2.5 block text-black dark:text-white font-medium">
                                NIK SAP (Username) <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nik_sap" placeholder="Misal: 2002005" required
                                class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-blue-500 active:border-blue-500 disabled:cursor-default disabled:bg-whiter dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:focus:border-blue-500" />
                        </div>

                        {{-- Password Default --}}
                        <div>
                            <label class="mb-2.5 block text-black dark:text-white font-medium">
                                Password Akses <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="password" value="123" required
                                class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-blue-500 active:border-blue-500 disabled:cursor-default disabled:bg-whiter dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:focus:border-blue-500" />
                            <p class="text-xs text-gray-500 mt-1">Password bawaan diset ke <strong>123</strong>. Anda bisa mengubahnya jika diperlukan.</p>
                        </div>

                        {{-- Tombol Submit --}}
                        <button type="submit" class="flex w-full justify-center rounded bg-blue-600 p-3 font-bold text-white hover:bg-blue-700 transition shadow-sm dark:bg-blue-600 dark:hover:bg-blue-700">
                            Simpan & Buat Akun
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        {{-- Panduan --}}
        <div class="flex flex-col gap-9">
            <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-gray-700 dark:bg-gray-800">
                <div class="border-b border-stroke py-4 px-6.5 dark:border-gray-700">
                    <h3 class="font-bold text-black dark:text-white">
                        Panduan
                    </h3>
                </div>
                <div class="p-6.5 text-sm text-black dark:text-gray-300 space-y-4">
                    <p>
                        Gunakan form di samping untuk membuatkan akses login bagi peserta asesmen yang baru.
                    </p>
                    <ol class="list-decimal list-inside space-y-2">
                        <li>Pastikan <strong>NIK SAP</strong> diketik dengan benar, karena akan digunakan sebagai "Username" saat login.</li>
                        <li>Sistem otomatis menolak pembuatan akun jika NIK SAP sudah ada di database.</li>
                        <li>Berikan NIK SAP dan Password tersebut kepada peserta yang bersangkutan.</li>
                        <li>Peserta yang baru dibuatkan akun akan langsung berstatus <strong class="text-red-500">"Belum Diisi"</strong> di halaman Monitoring Dashboard.</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection