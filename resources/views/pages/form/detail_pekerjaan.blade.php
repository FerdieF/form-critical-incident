@extends('layouts.app')

<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<style>
    /* Biar bordernya nyatu sama tema TailAdmin kamu */
    .ql-toolbar.ql-snow {
        border-color: #E2E8F0 !important;
        border-top-left-radius: 0.375rem;
        border-top-right-radius: 0.375rem;
    }
    .ql-container.ql-snow {
        border-color: #E2E8F0 !important;
        border-bottom-left-radius: 0.375rem;
        border-bottom-right-radius: 0.375rem;
        font-family: inherit;
    }

    /* PERBAIKAN 1: Selesaikan masalah tinggi memanjang dengan fix height di container utama */
    #editor-struktur {
        height: 250px; /* Atur tinggi sesuai selera, Quill akan otomatis memunculkan scrollbar di dalam */
    }

    /* Memaksa gambar yang masuk agar menyesuaikan lebar editor */
    .ql-editor img {
        max-width: 100% !important;
        height: auto !important;
        display: block;
    }
    
    /* Mode Gelap (Dark Mode) Fix untuk Quill */
    .dark .ql-toolbar.ql-snow, .dark .ql-container.ql-snow {
        border-color: #4B5563 !important; 
    }
    .dark .ql-toolbar.ql-snow {
        background-color: #374151; 
    }
    .dark .ql-editor {
        color: #ffffff !important;
    }
    .dark .ql-editor.ql-blank::before {
        color: #9CA3AF !important; 
    }
    .dark .ql-snow .ql-stroke { stroke: #e5e7eb; }
    .dark .ql-snow .ql-fill, .dark .ql-snow .ql-stroke.ql-fill { fill: #e5e7eb; }
</style>

@section('content')
    <x-common.page-breadcrumb pageTitle="Data Detail Pekerjaan" />

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
                <h3 class="font-medium !text-black dark:!text-white">
                    V. DETAIL TUGAS & TANGGUNG JAWAB ({{ optional(auth()->user()->karyawan)->nama_lengkap ?? '' }})
                </h3>
            </div>
            
            <form action="{{ route('form.detail_pekerjaan.store') }}" method="POST" id="form-detail-pekerjaan">
                @csrf
                <input type="hidden" name="karyawan_id" value="{{ optional(auth()->user()->karyawan)->id }}">
                
                <div class="p-6.5">
                    
                    {{-- 1. TUGAS POSISI TERAKHIR --}}
                    <div class="mb-6">
                        <label class="mb-2.5 block font-medium !text-black dark:!text-white">Uraikan tugas untuk dua posisi terakhir bidang pekerjaan terakhir:</label>
                        <textarea name="tugas_dua_posisi_terakhir" rows="3" class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 outline-none focus:border-primary dark:border-gray-600 dark:bg-gray-800 !text-black dark:!text-white">{{ $karyawan->detailPekerjaan->tugas_dua_posisi_terakhir ?? '' }}</textarea>
                    </div>

                    {{-- 2. TABEL DINAMIS BAWAHAN --}}
                    <h4 class="font-bold !text-black dark:!text-white mb-4 mt-8">Data Bawahan Langsung</h4>
                    <p class="mb-4 text-sm !text-black dark:!text-gray-300">Sebutkan nama bawahan, di bagian apa dan sebagai apa mereka bekerja.</p>
                    
                    <div class="overflow-x-auto mb-6">
                        <table class="w-full table-auto">
                            <thead>
                                <tr class="bg-gray-100 text-left dark:bg-gray-700">
                                    <th class="py-4 px-4 font-bold !text-black dark:!text-white min-w-[200px]">Nama</th>
                                    <th class="py-4 px-4 font-bold !text-black dark:!text-white min-w-[200px]">Bagian</th>
                                    <th class="py-4 px-4 font-bold !text-black dark:!text-white min-w-[200px]">Peran / Jabatan</th>
                                    <th class="py-4 px-4 font-bold !text-black dark:!text-white text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-bawahan">
                                @if(isset($karyawan) && $karyawan->bawahans && $karyawan->bawahans->count() > 0)
                                    @foreach($karyawan->bawahans as $index => $bawahan)
                                    <tr>
                                        <td class="border-b border-stroke py-4 px-2 dark:border-gray-700">
                                            <input type="text" name="bawahan[{{ $index }}][nama]" value="{{ $bawahan->nama }}" class="w-full rounded border-[1.5px] border-stroke bg-transparent px-3 py-2 outline-none focus:border-primary dark:border-gray-600 dark:bg-gray-800 !text-black dark:!text-white">
                                        </td>
                                        <td class="border-b border-stroke py-4 px-2 dark:border-gray-700">
                                            <input type="text" name="bawahan[{{ $index }}][bagian]" value="{{ $bawahan->bagian ?? '' }}" class="w-full rounded border-[1.5px] border-stroke bg-transparent px-3 py-2 outline-none focus:border-primary dark:border-gray-600 dark:bg-gray-800 !text-black dark:!text-white">
                                        </td>
                                        <td class="border-b border-stroke py-4 px-2 dark:border-gray-700">
                                            <input type="text" name="bawahan[{{ $index }}][peran]" value="{{ $bawahan->peran ?? '' }}" class="w-full rounded border-[1.5px] border-stroke bg-transparent px-3 py-2 outline-none focus:border-primary dark:border-gray-600 dark:bg-gray-800 !text-black dark:!text-white">
                                        </td>
                                        <td class="border-b border-stroke py-4 px-2 dark:border-gray-700 text-center">
                                            <button type="button" class="text-danger dark:!text-red-400 hover:text-opacity-70 font-medium btn-hapus text-sm transition-all">Hapus</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="border-b border-stroke py-4 px-2 dark:border-gray-700">
                                            <input type="text" name="bawahan[0][nama]" class="w-full rounded border-[1.5px] border-stroke bg-transparent px-3 py-2 outline-none focus:border-primary dark:border-gray-600 dark:bg-gray-800 !text-black dark:!text-white">
                                        </td>
                                        <td class="border-b border-stroke py-4 px-2 dark:border-gray-700">
                                            <input type="text" name="bawahan[0][bagian]" class="w-full rounded border-[1.5px] border-stroke bg-transparent px-3 py-2 outline-none focus:border-primary dark:border-gray-600 dark:bg-gray-800 !text-black dark:!text-white">
                                        </td>
                                        <td class="border-b border-stroke py-4 px-2 dark:border-gray-700">
                                            <input type="text" name="bawahan[0][peran]" class="w-full rounded border-[1.5px] border-stroke bg-transparent px-3 py-2 outline-none focus:border-primary dark:border-gray-600 dark:bg-gray-800 !text-black dark:!text-white">
                                        </td>
                                        <td class="border-b border-stroke py-4 px-2 dark:border-gray-700 text-center">
                                            <button type="button" class="text-danger dark:!text-red-400 hover:text-opacity-70 font-medium btn-hapus text-sm transition-all">Hapus</button>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        
                        <button type="button" id="btn-tambah-bawahan" class="mt-4 flex justify-center rounded border border-stroke bg-gray-100 py-2 px-4 font-medium !text-black hover:bg-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:!text-white dark:hover:bg-gray-600 transition-all text-sm">
                            + Tambah Bawahan
                        </button>
                    </div>

                    {{-- 3. QUILL EDITOR STRUKTUR ORGANISASI --}}
                    <div class="mb-6">
                        <label class="mb-2.5 block font-medium !text-black dark:!text-white">Deskripsikan posisi Anda dalam struktur organisasi tempat Anda bekerja:</label>
                        
                        {{-- PERBAIKAN 2: Hapus atribut 'value' agar tag HTML dari database tidak merusak form --}}
                        <input type="hidden" name="struktur_organisasi" id="input-struktur">
                        
                        {{-- PERBAIKAN 3: Hapus style="min-height: 150px;" karena sudah diatur di CSS atas --}}
                        <div id="editor-struktur" class="bg-transparent dark:bg-gray-800 !text-black dark:!text-white">
                            {!! $karyawan->detailPekerjaan->struktur_organisasi ?? '' !!}
                        </div>
                    </div>

                    {{-- 4. TANGGUNG JAWAB --}}
                    <div class="mb-6">
                        <label class="mb-2.5 block font-medium !text-black dark:!text-white">Apa saja tanggung jawab Anda pada pekerjaan/jabatan Anda sekarang?</label>
                        <textarea name="tanggung_jawab" rows="3" class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 outline-none focus:border-primary dark:border-gray-600 dark:bg-gray-800 !text-black dark:!text-white">{{ $karyawan->detailPekerjaan->tanggung_jawab ?? '' }}</textarea>
                    </div>

                    {{-- 5. URAIAN TANGGUNG JAWAB --}}
                    <div class="mb-6">
                        <label class="mb-2.5 block font-medium !text-black dark:!text-white">Uraikan secara terperinci apa saja yang Anda lakukan selama ini dalam rangka menunaikan tiap-tiap tanggung jawab di atas:</label>
                        <textarea name="uraian_tanggung_jawab" rows="4" class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 outline-none focus:border-primary dark:border-gray-600 dark:bg-gray-800 !text-black dark:!text-white">{{ $karyawan->detailPekerjaan->uraian_tanggung_jawab ?? '' }}</textarea>
                    </div>

                    <div class="mt-8 flex justify-end">
                        <button type="submit" class="flex w-full md:w-1/3 justify-center rounded bg-green-500 p-3 font-medium text-white transition hover:bg-green-600 shadow">
                            Simpan Detail Pekerjaan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // 1. Inisialisasi Quill Editor
            var quill = new Quill('#editor-struktur', {
                theme: 'snow',
                placeholder: 'Tuliskan deskripsi struktur organisasi di sini...',
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline', 'strike'], 
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }], 
                        ['link', 'image'], 
                        ['clean'] 
                    ]
                }
            });

            // 2. Sinkronisasi editor ke input hidden sebelum submit
            const form = document.getElementById('form-detail-pekerjaan');

            form.addEventListener('submit', function(e) {
                const inputStruktur = document.getElementById('input-struktur');
                
                // Ambil HTML dari Quill
                const htmlContent = quill.root.innerHTML;
                
                // Masukkan ke hidden input
                inputStruktur.value = htmlContent;
            });

            // 3. Logika Tambah/Hapus Bawahan
            const btnTambah = document.getElementById('btn-tambah-bawahan');
            const tbody = document.getElementById('tbody-bawahan');
            
            let arrayIndex = {{ isset($karyawan) && $karyawan->bawahans && $karyawan->bawahans->count() > 0 ? $karyawan->bawahans->count() : 1 }};

            btnTambah.addEventListener('click', function () {
                const barisBaru = `
                    <tr>
                        <td class="border-b border-stroke py-4 px-2 dark:border-gray-700">
                            <input type="text" name="bawahan[${arrayIndex}][nama]" class="w-full rounded border-[1.5px] border-stroke bg-transparent px-3 py-2 outline-none focus:border-primary dark:border-gray-600 dark:bg-gray-800 !text-black dark:!text-white">
                        </td>
                        <td class="border-b border-stroke py-4 px-2 dark:border-gray-700">
                            <input type="text" name="bawahan[${arrayIndex}][bagian]" class="w-full rounded border-[1.5px] border-stroke bg-transparent px-3 py-2 outline-none focus:border-primary dark:border-gray-600 dark:bg-gray-800 !text-black dark:!text-white">
                        </td>
                        <td class="border-b border-stroke py-4 px-2 dark:border-gray-700">
                            <input type="text" name="bawahan[${arrayIndex}][peran]" class="w-full rounded border-[1.5px] border-stroke bg-transparent px-3 py-2 outline-none focus:border-primary dark:border-gray-600 dark:bg-gray-800 !text-black dark:!text-white">
                        </td>
                        <td class="border-b border-stroke py-4 px-2 dark:border-gray-700 text-center">
                            <button type="button" class="text-danger dark:!text-red-400 hover:text-opacity-70 font-medium btn-hapus text-sm transition-all">Hapus</button>
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