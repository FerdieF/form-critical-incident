@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Entry Data Karyawan" />

    <div class="grid grid-cols-1 gap-6">
        
        @if(session('success'))
            <div class="mb-6 flex w-full rounded border-l-6 border-[#10B981] bg-[#10B981] px-7 py-4 shadow-md">
                <div class="w-full">
                    <h5 class="text-lg font-bold text-white mb-1">Berhasil!</h5>
                    <p class="text-base text-white font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <div class="rounded-sm border border-stroke bg-white shadow-default dark:border-gray-700 dark:bg-gray-800">
            <div class="border-b border-stroke py-4 px-6.5 dark:border-gray-700">
                <h3 class="font-medium text-black dark:text-white">
                    I. Identitas Diri & Perusahaan
                </h3>
            </div>
            
            <form action="{{ route('form.store') }}" method="POST">
                @csrf
                <div class="p-6.5">
                    
                    <div class="mb-4.5 flex flex-col gap-6 xl:flex-row">
                        <div class="w-full xl:w-1/2">
                            <label class="mb-2.5 block text-black dark:text-white">
                                Nama Lengkap <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nama_lengkap" 
                                value="{{ old('nama_lengkap', $karyawan->nama_lengkap ?? auth()->user()->name) }}" 
                                placeholder="Masukkan nama lengkap" required
                                class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:focus:border-primary" />
                        </div>
                        <div class="w-full xl:w-1/2">
                            <label class="mb-2.5 block text-black dark:text-white">NIK SAP <span class="text-meta-1">*</span></label>
                            <input type="text" name="nik_sap" readonly value="{{ auth()->user()->nik_sap }}" 
                                class="w-full rounded border-[1.5px] border-stroke bg-gray-100 py-3 px-5 text-black outline-none transition cursor-not-allowed dark:border-gray-600 dark:bg-gray-700 dark:text-white" />
                        </div>
                    </div>

                    <div class="mb-4.5 flex flex-col gap-6 xl:flex-row">
                        <div class="w-full xl:w-1/2">
                            <label class="mb-2.5 block text-black dark:text-white">Tempat Lahir <span class="text-meta-1">*</span></label>
                            <input type="text" name="tempat_lahir" required value="{{ old('tempat_lahir', optional($karyawan)->tempat_lahir) }}" 
                                class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary dark:border-gray-600 dark:bg-gray-900 dark:text-white dark:focus:border-primary" />
                        </div>
                        <div class="w-full xl:w-1/2">
                            <label class="mb-2.5 block text-black dark:text-white">Tanggal Lahir (Bulan/Tanggal/Tahun) <span class="text-meta-1">*</span></label>
                            <input type="date" name="tanggal_lahir" required value="{{ old('tanggal_lahir', optional($karyawan)->tanggal_lahir) }}" 
                                class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary dark:border-gray-600 dark:bg-gray-900 dark:text-white dark:focus:border-primary" />
                        </div>
                    </div>

                    <div class="mb-4.5 flex flex-col gap-6 xl:flex-row">
                        <div class="w-full xl:w-1/3">
                            <label class="mb-2.5 block text-black dark:text-white">Jenis Kelamin</label>
                            <select name="jenis_kelamin" required class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary dark:border-gray-600 dark:bg-gray-900 dark:text-white dark:focus:border-primary">
                                <option value="Laki-laki" {{ optional($karyawan)->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ optional($karyawan)->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        <div class="w-full xl:w-1/3">
                            <label class="mb-2.5 block text-black dark:text-white">Agama <span class="text-meta-1">*</span></label>
                            <select name="agama" required class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary dark:border-gray-600 dark:bg-gray-900 dark:text-white dark:focus:border-primary">
                                <option value="" disabled {{ optional($karyawan)->agama ? '' : 'selected' }}>-- Pilih Agama --</option>
                                <option value="Islam" {{ optional($karyawan)->agama == 'Islam' ? 'selected' : '' }}>Islam</option>
                                <option value="Kristen Protestan" {{ optional($karyawan)->agama == 'Kristen Protestan' ? 'selected' : '' }}>Kristen Protestan</option>
                                <option value="Katolik" {{ optional($karyawan)->agama == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                <option value="Hindu" {{ optional($karyawan)->agama == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                <option value="Buddha" {{ optional($karyawan)->agama == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                <option value="Konghucu" {{ optional($karyawan)->agama == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                            </select>
                        </div>
                        <div class="w-full xl:w-1/3">
                            <label class="mb-2.5 block text-black dark:text-white">Status</label>
                            <select name="status_pernikahan" required class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary dark:border-gray-600 dark:bg-gray-900 dark:text-white dark:focus:border-primary">
                                <option value="Belum Kawin" {{ optional($karyawan)->status_pernikahan == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                                <option value="Kawin" {{ optional($karyawan)->status_pernikahan == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                                <option value="Janda" {{ optional($karyawan)->status_pernikahan == 'Janda' ? 'selected' : '' }}>Janda</option>
                                <option value="Duda" {{ optional($karyawan)->status_pernikahan == 'Duda' ? 'selected' : '' }}>Duda</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4.5">
                        <label class="mb-2.5 block text-black dark:text-white">Alamat Domisili <span class="text-meta-1">*</span></label>
                        <textarea name="alamat" rows="2" required class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary dark:border-gray-600 dark:bg-gray-900 dark:text-white dark:focus:border-primary">{{ old('alamat', optional($karyawan)->alamat) }}</textarea>
                    </div>

                    <div class="border-t border-stroke my-6 dark:border-gray-700"></div>

                    <div class="mb-4.5 flex flex-col gap-6 xl:flex-row">
                        <div class="w-full xl:w-1/2">
                            <label class="mb-2.5 block text-black dark:text-white">Perusahaan</label>
                            <input type="text" name="perusahaan" required value="{{ old('perusahaan', optional($karyawan)->perusahaan ?? 'PT PERKEBUNAN NUSANTARA IV') }}" 
                                class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary dark:border-gray-600 dark:bg-gray-900 dark:text-white dark:focus:border-primary" />
                        </div>
                        <div class="w-full xl:w-1/2">
                            <label class="mb-2.5 block text-black dark:text-white">Golongan/Grade</label>
                            <input type="text" name="golongan" required value="{{ old('golongan', optional($karyawan)->golongan) }}" 
                                class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary dark:border-gray-600 dark:bg-gray-900 dark:text-white dark:focus:border-primary" />
                        </div>
                    </div>

                    <div class="mb-4.5 flex flex-col gap-6 xl:flex-row">
                        <div class="w-full xl:w-1/2">
                            <label class="mb-2.5 block text-black dark:text-white">Jabatan Saat Ini</label>
                            <input type="text" name="jabatan" required value="{{ old('jabatan', optional($karyawan)->jabatan) }}" 
                                class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary dark:border-gray-600 dark:bg-gray-900 dark:text-white dark:focus:border-primary" />
                        </div>
                        <div class="w-full xl:w-1/2">
                            <label class="mb-2.5 block text-black dark:text-white">Alamat Perusahaan</label>
                            <input type="text" name="alamat_perusahaan" required value="{{ old('alamat_perusahaan', optional($karyawan)->alamat_perusahaan) }}" 
                                class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary dark:border-gray-600 dark:bg-gray-900 dark:text-white dark:focus:border-primary" />
                        </div>
                    </div>

                    <div class="mb-6 flex flex-col gap-6 xl:flex-row">
                        <div class="w-full xl:w-1/2">
                            <label class="mb-2.5 block text-black dark:text-white">Nama Atasan Langsung</label>
                            <input type="text" name="nama_atasan_langsung" required value="{{ old('nama_atasan_langsung', optional($karyawan)->nama_atasan_langsung) }}" 
                                class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary dark:border-gray-600 dark:bg-gray-900 dark:text-white dark:focus:border-primary" />
                        </div>
                        <div class="w-full xl:w-1/2">
                            <label class="mb-2.5 block text-black dark:text-white">Jabatan Atasan Langsung</label>
                            <input type="text" name="jabatan_atasan_langsung" required value="{{ old('jabatan_atasan_langsung', optional($karyawan)->jabatan_atasan_langsung) }}" 
                                class="w-full rounded border-[1.5px] border-stroke bg-transparent py-3 px-5 text-black outline-none transition focus:border-primary active:border-primary dark:border-gray-600 dark:bg-gray-900 dark:text-white dark:focus:border-primary" />
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="submit" class="flex w-full md:w-1/3 justify-center rounded bg-green-500 p-3 font-medium text-white transition hover:bg-green-600">
                            Simpan Data Diri
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
