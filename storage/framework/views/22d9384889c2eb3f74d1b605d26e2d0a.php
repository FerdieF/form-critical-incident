<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Form Karpim - <?php echo e($karyawan->nama_lengkap); ?></title>
    <?php echo $__env->make('pages.admin.partials.karpim-print-styles', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</head>
<body>
    <div class="print-toolbar">
        <a href="<?php echo e(url()->previous()); ?>">Kembali</a>
        <button type="button" onclick="window.print()">Cetak Data</button>
    </div>

    <?php echo $__env->make('pages.admin.partials.karpim-print-form', ['karyawan' => $karyawan], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <script>
        window.onload = function () {
            window.print();
        };
    </script>
</body>
</html>
<?php /**PATH D:\Apply Kerja\tailadmin-laravel-main\resources\views/pages/admin/print-individu.blade.php ENDPATH**/ ?>