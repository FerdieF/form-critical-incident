<div class="max-w-full overflow-x-auto">
    <table class="w-full table-auto">
        <thead>
            <tr class="bg-gray-2 text-left dark:bg-meta-4">
                <th class="py-4 px-4 font-medium text-black dark:text-white">NIK SAP</th>
                <th class="py-4 px-4 font-medium text-black dark:text-white">Nama Lengkap</th>
                <th class="py-4 px-4 font-medium text-black dark:text-white">Jabatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($karyawans as $karyawan)
            <tr>
                <td class="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                    <p class="text-black dark:text-white">{{ $karyawan->nik_sap }}</p>
                </td>
                <td class="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                    <p class="text-black dark:text-white">{{ $karyawan->nama_lengkap }}</p>
                </td>
                <td class="border-b border-[#eee] py-5 px-4 dark:border-strokedark">
                    <p class="text-black dark:text-white">{{ $karyawan->jabatan ?? '-' }}</p>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="border-b border-[#eee] py-5 px-4 text-center dark:border-strokedark">
                    <p class="text-black dark:text-white">Belum ada data karyawan.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>