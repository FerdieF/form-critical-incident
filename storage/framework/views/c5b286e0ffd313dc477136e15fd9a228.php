<?php
    $text = fn ($value, $fallback = '') => filled($value) ? $value : $fallback;
    $plain = fn ($value) => trim(strip_tags($value ?? ''));
    $printedAt = \Illuminate\Support\Carbon::now('Asia/Jakarta');
    $monthNames = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember',
    ];
    $printedDate = $printedAt->format('j') . ' ' . $monthNames[(int) $printedAt->format('n')] . ' ' . $printedAt->format('Y');
    $formatDate = function ($value) {
        if (blank($value)) {
            return '';
        }

        try {
            return \Illuminate\Support\Carbon::parse($value)->format('d-m-Y');
        } catch (\Throwable $exception) {
            return $value;
        }
    };
    $formatLongDate = function ($value) use ($monthNames) {
        if (blank($value)) {
            return '';
        }

        try {
            $date = \Illuminate\Support\Carbon::parse($value);
            return $date->format('j') . ' ' . $monthNames[(int) $date->format('n')] . ' ' . $date->format('Y');
        } catch (\Throwable $exception) {
            return $value;
        }
    };

    $birth = trim($text($karyawan->tempat_lahir) . (filled($karyawan->tanggal_lahir) ? ' / ' . $formatDate($karyawan->tanggal_lahir) : ''));
    $statusChoices = ['Belum Kawin', 'Kawin', 'Janda', 'Duda'];
    $genderChoices = ['Laki-laki', 'Perempuan'];
    $families = $karyawan->keluargas ?? collect();
    $familyLabels = ['Istri / Suami', 'Anak 1', 'Anak 2', 'Anak 3', 'Anak 4', 'Anak 5'];
    $formalRows = ($karyawan->pendidikans ?? collect())->where('kategori', 'Formal')->values();
    $informalRows = ($karyawan->pendidikans ?? collect())->where('kategori', 'Informal')->values();
    $workRows = ($karyawan->pengalamanKerjas ?? collect())->values();
    $subordinateRows = ($karyawan->bawahans ?? collect())->values();
    $successIncident = ($karyawan->criticalIncidents ?? collect())->firstWhere('jenis_insiden', 'Sukses');
    $failureIncident = ($karyawan->criticalIncidents ?? collect())->firstWhere('jenis_insiden', 'Gagal');
    $check = fn ($value, $expected) => strcasecmp(trim((string) $value), trim((string) $expected)) === 0 ? 'X' : '';
    $structureHtml = data_get($karyawan->detailPekerjaan, 'struktur_organisasi') ?? '';
    $structurePlain = trim(preg_replace('/\s+/u', ' ', html_entity_decode(strip_tags($structureHtml), ENT_QUOTES | ENT_HTML5, 'UTF-8')));
    $structureHasMedia = preg_match('/<(img|table|ul|ol|svg|figure)\b/i', $structureHtml);
    $structureIsBlank = blank($structurePlain) && !$structureHasMedia;
?>

<section class="sheet">
    <div class="brand-header">
        <img src="<?php echo e(asset('images/logo-ptpn4.png')); ?>" alt="Logo PTPN4">
        <div class="brand-title">
            PT Perkebunan Nusantara IV
            <span>Regional I</span>
        </div>
        <div class="form-code">FDP - 1</div>
    </div>

    <div class="form-title">FORMULIR DATA PRIBADI</div>
    <div class="guide">
        <div>Isilah dengan huruf cetak</div>
        <div>Berilah tanda silang ( X ) pada jawaban untuk pertanyaan pilihan</div>
    </div>

    <div class="section-title">I. Identitas Diri</div>
    <table class="form-table compact">
        <tr>
            <td class="label">Nama Lengkap</td>
            <td class="colon">:</td>
            <td class="value"><?php echo e($text($karyawan->nama_lengkap)); ?></td>
        </tr>
        <tr>
            <td class="label">Tempat/Tanggal Lahir</td>
            <td class="colon">:</td>
            <td class="value"><?php echo e($birth); ?></td>
        </tr>
        <tr>
            <td class="label">Jenis Kelamin</td>
            <td class="colon">:</td>
            <td class="value">
                <?php $__currentLoopData = $genderChoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $choice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <span class="choice"><span class="choice-mark"><?php echo e($check($karyawan->jenis_kelamin, $choice) ?: $check($karyawan->jenis_kelamin, substr($choice, 0, 1))); ?></span> <?php echo e($choice); ?></span>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </td>
        </tr>
        <tr>
            <td class="label">Alamat</td>
            <td class="colon">:</td>
            <td class="value"><?php echo e($text($karyawan->alamat)); ?></td>
        </tr>
        <tr>
            <td class="label">Agama</td>
            <td class="colon">:</td>
            <td class="value"><?php echo e($text($karyawan->agama)); ?></td>
        </tr>
        <tr>
            <td class="label">Status Pernikahan</td>
            <td class="colon">:</td>
            <td class="value">
                <?php $__currentLoopData = $statusChoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $choice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <span class="choice"><span class="choice-mark"><?php echo e($check($karyawan->status_pernikahan, $choice)); ?></span> <?php echo e($choice); ?></span>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <span class="muted-note">*coret yang bukan</span>
            </td>
        </tr>
        <tr>
            <td class="label">Jabatan saat ini</td>
            <td class="colon">:</td>
            <td class="value"><?php echo e($text($karyawan->jabatan)); ?></td>
        </tr>
        <tr>
            <td class="label">NIK SAP</td>
            <td class="colon">:</td>
            <td class="value"><?php echo e($text($karyawan->nik_sap)); ?></td>
        </tr>
        <tr>
            <td class="label">Golongan/Grade</td>
            <td class="colon">:</td>
            <td class="value"><?php echo e($text($karyawan->golongan)); ?></td>
        </tr>
        <tr>
            <td class="label">Perusahaan</td>
            <td class="colon">:</td>
            <td class="value"><?php echo e($text($karyawan->perusahaan)); ?></td>
        </tr>
        <tr>
            <td class="label">Alamat Perusahaan</td>
            <td class="colon">:</td>
            <td class="value"><?php echo e($text($karyawan->alamat_perusahaan)); ?></td>
        </tr>
        <tr>
            <td class="label">Nama Atasan Langsung</td>
            <td class="colon">:</td>
            <td class="value"><?php echo e($text($karyawan->nama_atasan_langsung)); ?></td>
        </tr>
        <tr>
            <td class="label">Jabatan Atasan Langsung</td>
            <td class="colon">:</td>
            <td class="value"><?php echo e($text($karyawan->jabatan_atasan_langsung)); ?></td>
        </tr>
    </table>

    <div class="section-title">II. Lingkungan Keluarga</div>
    <div class="muted-note">Susunan Keluarga ( Istri / Suami dan Anak-anak )</div>
    <table class="form-table compact">
        <tr>
            <th style="width: 25mm;"></th>
            <th>Nama</th>
            <th style="width: 13mm;">L / P</th>
            <th style="width: 31mm;">Tempat/Tgl Lahir</th>
            <th style="width: 24mm;">Pendidikan</th>
            <th style="width: 27mm;">Pekerjaan</th>
        </tr>
        <?php $__currentLoopData = $familyLabels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $family = $families[$index] ?? null; ?>
            <tr>
                <td><?php echo e($family->hubungan ?? $label); ?></td>
                <td><?php echo e($family->nama ?? ''); ?></td>
                <td style="text-align: center;"><?php echo e($family->jenis_kelamin ?? ''); ?></td>
                <td><?php echo e($family ? trim($text($family->tempat_lahir) . (filled($family->tanggal_lahir) ? ' / ' . $formatDate($family->tanggal_lahir) : '')) : ''); ?></td>
                <td><?php echo e($family->pendidikan ?? ''); ?></td>
                <td><?php echo e($family->pekerjaan ?? ''); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </table>
    <div class="muted-note">(dapat dilanjutkan ke halaman sebaliknya)</div>

    <div class="section-title">III. Riwayat Pendidikan</div>
    <div class="muted-note">Pendidikan Formal</div>
    <table class="form-table compact">
        <tr>
            <th style="width: 23mm;"></th>
            <th>Nama Sekolah</th>
            <th style="width: 30mm;">Jurusan</th>
            <th style="width: 29mm;">Tempat</th>
            <th style="width: 24mm;">Thn s/d Thn</th>
            <th style="width: 25mm;">Keterangan</th>
        </tr>
        <?php for($i = 0; $i < max(4, $formalRows->count()); $i++): ?>
            <?php
                $level = ['Pasca S1', 'Univ/Inst', 'Akademi', 'SLTA'][$i] ?? '';
                $edu = $formalRows[$i] ?? null;
            ?>
            <tr>
                <td><?php echo e($edu->tingkat ?? $level); ?></td>
                <td><?php echo e($edu->nama_institusi ?? ''); ?></td>
                <td><?php echo e($edu->jurusan ?? ''); ?></td>
                <td><?php echo e($edu->tempat ?? ''); ?></td>
                <td><?php echo e($edu->tahun ?? ''); ?></td>
                <td><?php echo e($edu->keterangan ?? ''); ?></td>
            </tr>
        <?php endfor; ?>
    </table>

    <div class="muted-note" style="margin-top: 2mm;">Pendidikan Informal ( Kursus atau Training )</div>
    <table class="form-table compact">
        <tr>
            <th>Jenis Kursus / Training</th>
            <th style="width: 32mm;">Tempat</th>
            <th style="width: 25mm;">Tahun</th>
            <th style="width: 35mm;">Keterangan</th>
        </tr>
        <?php for($i = 0; $i < max(3, $informalRows->count()); $i++): ?>
            <?php $edu = $informalRows[$i] ?? null; ?>
            <tr>
                <td><?php echo e($edu->nama_institusi ?? ''); ?></td>
                <td><?php echo e($edu->tempat ?? ''); ?></td>
                <td><?php echo e($edu->tahun ?? ''); ?></td>
                <td><?php echo e($edu->keterangan ?? ''); ?></td>
            </tr>
        <?php endfor; ?>
    </table>
</section>

<section class="sheet">
    <div class="brand-header">
        <img src="<?php echo e(asset('images/logo-ptpn4.png')); ?>" alt="Logo PTPN4">
        <div class="brand-title">
            PT Perkebunan Nusantara IV
            <span>Regional I</span>
        </div>
        <div class="form-code">FDP - 2</div>
    </div>

    <div class="section-title">IV. Riwayat Pekerjaan</div>
    <div>1. Uraikan dengan singkat pekerjaan Anda selama ini (dimulai dari posisi terakhir):</div>
    <table class="form-table compact">
        <tr>
            <th style="width: 31mm;">Jabatan</th>
            <th style="width: 31mm;">Bln/Thn s/d Bln/Thn</th>
            <th>Perusahaan</th>
            <th style="width: 36mm;">Bagian/Dept.</th>
        </tr>
        <?php for($i = 0; $i < max(5, $workRows->count()); $i++): ?>
            <?php $work = $workRows[$i] ?? null; ?>
            <tr>
                <td><?php echo e($work->jabatan ?? ''); ?></td>
                <td><?php echo e($work->masa_kerja ?? ''); ?></td>
                <td><?php echo e($work->perusahaan ?? ''); ?></td>
                <td><?php echo e($work->bagian ?? ''); ?></td>
            </tr>
        <?php endfor; ?>
    </table>

    <div style="margin-top: 3mm;">2. Uraikan tugas untuk dua posisi terakhir bidang pekerjaan di atas.</div>
    <div class="line-box large-box"><?php echo e(data_get($karyawan->detailPekerjaan, 'tugas_dua_posisi_terakhir')); ?></div>

    <div class="section-title">V. Data Pekerjaan</div>
    <div>1. Berapa orang bawahan langsung Anda di jabatan sekarang? Di bagian apa dan sebagai apa mereka bekerja? <?php echo e($subordinateRows->count() ?: ' . . . . . . '); ?> orang.</div>
    <table class="form-table compact">
        <tr>
            <th style="width: 12mm;">No</th>
            <th>Nama</th>
            <th style="width: 42mm;">Bagian</th>
            <th style="width: 47mm;">Peran/jabatan</th>
        </tr>
        <?php for($i = 0; $i < max(5, $subordinateRows->count()); $i++): ?>
            <?php $subordinate = $subordinateRows[$i] ?? null; ?>
            <tr>
                <td style="text-align: center;"><?php echo e($i + 1); ?></td>
                <td><?php echo e($subordinate->nama ?? ''); ?></td>
                <td><?php echo e($subordinate->bagian ?? ''); ?></td>
                <td><?php echo e($subordinate->peran ?? ''); ?></td>
            </tr>
        <?php endfor; ?>
    </table>

    <div style="margin-top: 3mm;">Untuk memperoleh gambaran lebih jelas mengenai posisi jabatan Anda di dalam struktur organisasi, tolong Anda gambarkan di bawah ini struktur organisasi tempat Anda bekerja, dan dimana posisi jabatan Anda.</div>
    <div class="line-box large-box struktur-organisasi-content quill-print-content">
        <?php if (! ($structureIsBlank)): ?>
            <?php echo $structureHtml; ?>

        <?php endif; ?>
    </div>

    <div style="margin-top: 3mm;">Apa saja tanggungjawab Anda pada pekerjaan/jabatan Anda sekarang?</div>
    <div class="line-box"><?php echo e(data_get($karyawan->detailPekerjaan, 'tanggung_jawab')); ?></div>

    <div style="margin-top: 3mm;">Uraikan secara terperinci apa saja yang Anda lakukan selama ini dalam rangka menunaikan tiap-tiap tanggungjawab di atas</div>
    <div class="line-box large-box"><?php echo e(data_get($karyawan->detailPekerjaan, 'uraian_tanggung_jawab')); ?></div>
</section>

<section class="sheet">
    <div class="brand-header">
        <img src="<?php echo e(asset('images/logo-ptpn4.png')); ?>" alt="Logo PTPN4">
        <div class="brand-title">
            PT Perkebunan Nusantara IV
            <span>Regional I</span>
        </div>
        <div class="form-code">FDP - 3</div>
    </div>

    <div class="section-title">VI. Kondisi Kerja</div>
    <table class="form-table">
        <tr>
            <td>
                Apakah penghasilan yang Anda terima saat ini sesuai dengan pekerjaan yang Anda lakukan? Jelaskan pendapat Anda?
                <div style="margin-top: 1.5mm;">
                    <span class="choice"><span class="choice-mark"><?php echo e($check(data_get($karyawan->kondisiKerja, 'penghasilan_sesuai'), 'Cukup')); ?></span> Cukup</span>
                    <span class="choice"><span class="choice-mark"><?php echo e($check(data_get($karyawan->kondisiKerja, 'penghasilan_sesuai'), 'Kurang')); ?></span> Kurang</span>
                </div>
                <div class="line-box" style="margin-top: 1.5mm;"><?php echo e(data_get($karyawan->kondisiKerja, 'penghasilan_penjelasan')); ?></div>
            </td>
        </tr>
        <tr>
            <td>
                Adakah jaminan-jaminan lain yang belum diberikan oleh perusahaan yang Anda anggap penting untuk diberikan? Jelaskan pendapat Anda!
                <div style="margin-top: 1.5mm;">
                    <span class="choice"><span class="choice-mark"><?php echo e($check(data_get($karyawan->kondisiKerja, 'jaminan_belum_diberikan'), 'Ada')); ?></span> Ada</span>
                    <span class="choice"><span class="choice-mark"><?php echo e($check(data_get($karyawan->kondisiKerja, 'jaminan_belum_diberikan'), 'Tidak Ada')); ?></span> Tidak Ada</span>
                </div>
                <div class="line-box" style="margin-top: 1.5mm;"><?php echo e(data_get($karyawan->kondisiKerja, 'jaminan_penjelasan')); ?></div>
            </td>
        </tr>
        <tr>
            <td>
                Bagaimanakah kondisi kerja Anda (tempat, suasana, tugas) saat ini?
                <div style="margin-top: 1.5mm;">
                    <span class="choice"><span class="choice-mark"><?php echo e($check(data_get($karyawan->kondisiKerja, 'kondisi_kerja_saat_ini'), 'Baik')); ?></span> Baik</span>
                    <span class="choice"><span class="choice-mark"><?php echo e($check(data_get($karyawan->kondisiKerja, 'kondisi_kerja_saat_ini'), 'Cukup Baik')); ?></span> Cukup Baik</span>
                    <span class="choice"><span class="choice-mark"><?php echo e($check(data_get($karyawan->kondisiKerja, 'kondisi_kerja_saat_ini'), 'Perlu Perbaikan')); ?></span> Perlu Perbaikan</span>
                </div>
                <div style="margin-top: 2mm;">Ceritakan kondisi yang Anda maksud, dan usulan perbaikan yang perlu dilakukan:</div>
                <div class="line-box" style="margin-top: 1.5mm;"><?php echo e(data_get($karyawan->kondisiKerja, 'kondisi_kerja_penjelasan')); ?></div>
            </td>
        </tr>
        <tr>
            <td>
                Bagaimanakah penilaian PRESTASI yang diberikan perusahaan terhadap hasil kerja Anda selama ini?
                <div style="margin-top: 1.5mm;">
                    <span class="choice"><span class="choice-mark"><?php echo e($check(data_get($karyawan->kondisiKerja, 'penilaian_prestasi'), 'Cukup Sesuai')); ?></span> Cukup Sesuai</span>
                    <span class="choice"><span class="choice-mark"><?php echo e($check(data_get($karyawan->kondisiKerja, 'penilaian_prestasi'), 'Kurang')); ?></span> Kurang</span>
                    <span class="choice"><span class="choice-mark"><?php echo e($check(data_get($karyawan->kondisiKerja, 'penilaian_prestasi'), 'Kurang Sekali')); ?></span> Kurang Sekali</span>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                Ada beberapa aspek / situasi / kondisi yang membuat Anda dapat optimal dalam bekerja. Jelaskan aspek apa saja yang dapat mendukung optimalisasi Anda dalam bekerja?
                <div class="line-box large-box" style="margin-top: 1.5mm;"><?php echo e(data_get($karyawan->kondisiKerja, 'aspek_optimalisasi')); ?></div>
            </td>
        </tr>
    </table>
</section>

<section class="sheet">
    <div class="brand-header">
        <img src="<?php echo e(asset('images/logo-ptpn4.png')); ?>" alt="Logo PTPN4">
        <div class="brand-title">
            PT Perkebunan Nusantara IV
            <span>Regional I</span>
        </div>
        <div class="form-code">FDP - 4</div>
    </div>

    <div class="section-title">VII. Minat dan Harapan</div>
    <div>Apakah yang Anda sukai dari pekerjaan Anda sekarang? (kondisi, tugas-tugas, dsb)</div>
    <div class="line-box"><?php echo e(data_get($karyawan->minatHarapan, 'hal_disukai')); ?></div>
    <div style="margin-top: 2mm;">Apa yang paling Anda tidak sukai dari pekerjaan/jabatan Anda sekarang? (kondisi, tugas-tugas, dsb) Mengapa?</div>
    <div class="line-box"><?php echo e(data_get($karyawan->minatHarapan, 'hal_tidak_disukai')); ?></div>
    <div style="margin-top: 2mm;">Mengapa Anda memilih karier (tipe pekerjaan) di bidang yang Anda tekuni sekarang ini?</div>
    <div class="line-box"><?php echo e(data_get($karyawan->minatHarapan, 'alasan_memilih_karier')); ?></div>
    <div style="margin-top: 2mm;">Uraikan ASPIRASI karier Anda dalam lima tahun mendatang!</div>
    <div class="line-box"><?php echo e(data_get($karyawan->minatHarapan, 'aspirasi_lima_tahun')); ?></div>

    <div>Uraikan usaha-usaha yang sudah Anda lakukan untuk mencapai tujuan tersebut (misal: training, kursus, dll)</div>
    <table class="form-table compact" style="margin-top: 1.5mm;">
        <tr>
            <th>Bidang yang diminati</th>
            <th style="width: 42mm;">Posisi</th>
            <th style="width: 65mm;">Usaha-usaha yang dilakukan</th>
        </tr>
        <tr>
            <td><?php echo e(data_get($karyawan->usahaAspirasi, 'bidang_diminati')); ?></td>
            <td><?php echo e(data_get($karyawan->usahaAspirasi, 'posisi')); ?></td>
            <td><?php echo e(data_get($karyawan->usahaAspirasi, 'usaha_dilakukan')); ?></td>
        </tr>
        <?php for($i = 0; $i < 3; $i++): ?>
            <tr>
                <td>&nbsp;</td>
                <td></td>
                <td></td>
            </tr>
        <?php endfor; ?>
    </table>
</section>

<section class="sheet">
    <div class="brand-header">
        <img src="<?php echo e(asset('images/logo-ptpn4.png')); ?>" alt="Logo PTPN4">
        <div class="brand-title">
            PT Perkebunan Nusantara IV
            <span>Regional I</span>
        </div>
        <div class="form-code">FDP - 5</div>
    </div>

    <div class="section-title">VIII. Kekuatan dan Kelemahan</div>
    <div>Apakah yang menjadi kekuatan ( Strong Point ) Anda?</div>
    <div class="line-box large-box"><?php echo e(data_get($karyawan->kekuatanKelemahan, 'kekuatan')); ?></div>
    <div style="margin-top: 3mm;">Apakah yang menjadi kelemahan ( Weak Point ) Anda?</div>
    <div class="line-box large-box"><?php echo e(data_get($karyawan->kekuatanKelemahan, 'kelemahan')); ?></div>

    <div class="signature-row">
        <div></div>
        <div class="signature-box">
            <div><?php echo e($printedDate); ?></div>
            <div class="signature-space"></div>
            <div>(<?php echo e($text($karyawan->nama_lengkap)); ?>)</div>
        </div>
    </div>
</section>

<?php $__currentLoopData = [
    ['title' => 'Pengalaman Sukses Besar', 'incident' => $successIncident, 'code' => 'CI - 1', 'kind' => 'sukses besar yang paling bermakna', 'prompt' => 'Ceritakan kejadian yang pernah Anda alami di dalam pekerjaan (boleh sewaktu bekerja di tempat lain sebelum yang sekarang) selama dua tahun terakhir ini yang dampak atau hasilnya merupakan suatu sukses besar yang paling bermakna bagi Anda. (Topiknya bebas, boleh mengenai apa saja. Contohnya, bisa mengenai perjuangan mencapai target tinggi, program penting yang berhasil dilaksanakan, problem sulit yang akhirnya bisa diatasi, dan sebagainya.)'],
    ['title' => 'Pengalaman Kegagalan Besar', 'incident' => $failureIncident, 'code' => 'CI - 2', 'kind' => 'kegagalan besar yang paling mengecewakan', 'prompt' => 'Ceritakan kejadian yang pernah Anda alami di dalam pekerjaan (boleh sewaktu bekerja di tempat lain sebelum yang sekarang) selama dua tahun terakhir ini yang hasilnya merupakan suatu kegagalan besar yang paling mengecewakan bagi Anda. (Topiknya bebas, boleh mengenai apa saja. Contohnya, bisa mengenai perjuangan mencapai target tinggi yang gagal, program penting yang akhirnya tidak terlaksana, problem sulit yang akhirnya tidak terpecahkan, dan sebagainya.)'],
]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $incidentPage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php $incident = $incidentPage['incident']; ?>
    <section class="sheet">
        <div class="brand-header">
            <img src="<?php echo e(asset('images/logo-ptpn4.png')); ?>" alt="Logo PTPN4">
            <div class="brand-title">
                PT Perkebunan Nusantara IV
                <span>Regional I</span>
            </div>
            <div class="form-code"><?php echo e($incidentPage['code']); ?></div>
        </div>

        <div class="form-title">FORM DATA CRITICAL INCIDENT</div>
        <table class="form-table compact">
            <tr>
                <td class="label">Nama</td>
                <td class="colon">:</td>
                <td><?php echo e($text($karyawan->nama_lengkap)); ?></td>
            </tr>
        </table>

        <p><?php echo e($incidentPage['prompt']); ?></p>

        <table class="form-table compact">
            <tr>
                <td style="width: 34mm;">Topik kejadian</td>
                <td><?php echo e($incident->topik ?? ''); ?></td>
            </tr>
            <tr>
                <td>Waktu kejadian<br>(seingatnya)</td>
                <td><?php echo e($formatLongDate($incident->waktu_kejadian ?? '')); ?></td>
            </tr>
        </table>

        <p>Paparkan pengalaman itu secara terperinci: bagaimana situasinya pada waktu itu, siapa saja yang terlibat, apa peranan Anda dan masing-masing orang lain yang terlibat di dalamnya, apa saja yang Anda lakukan, untuk apa Anda melakukannya, apa yang Anda pikirkan dan bagaimana perasaan Anda saat kejadian berlangsung.</p>

        <div class="avoid-break">
            <strong>Kejadiannya:</strong> Tuturkan kejadiannya secara terperinci dan runtut.
            <div class="line-box"><?php echo e($incident->kejadian ?? ''); ?></div>
        </div>
        <div class="avoid-break" style="margin-top: 2mm;">
            <strong>Situasinya:</strong> Bagaimana situasinya pada waktu itu? Apa penyebabnya?
            <div class="line-box"><?php echo e($incident->situasi ?? ''); ?></div>
        </div>
        <div class="avoid-break" style="margin-top: 2mm;">
            <strong>Para Pelaku:</strong> Siapa saja yang terlibat? Apa peranan mereka dalam kejadian itu?
            <div class="line-box"><?php echo e($incident->pelaku ?? ''); ?></div>
        </div>
        <div class="avoid-break" style="margin-top: 2mm;">
            <strong>Pikiran-pikiran, perasaan/emosi, keinginan:</strong> Apa yang pada waktu itu Anda pikirkan, rasakan dan ingin lakukan?
            <div class="line-box"><?php echo e($incident->pikiran_perasaan ?? ''); ?></div>
        </div>
        <div class="avoid-break" style="margin-top: 2mm;">
            <strong>Perilaku:</strong> Apa saja yang Anda lakukan? Apa saja yang Anda katakan pada waktu itu?
            <div class="line-box"><?php echo e($incident->perilaku ?? ''); ?></div>
        </div>
        <div class="avoid-break" style="margin-top: 2mm;">
            <strong>Hasilnya:</strong> Bagaimana akhir kejadian itu? Apa yang terjadi?
            <div class="line-box"><?php echo e($incident->hasil ?? ''); ?></div>
        </div>
    </section>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH D:\Apply Kerja\tailadmin-laravel-main\resources\views/pages/admin/partials/karpim-print-form.blade.php ENDPATH**/ ?>