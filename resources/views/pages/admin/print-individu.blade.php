<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Form Karpim - {{ $karyawan->nama_lengkap }}</title>
    @include('pages.admin.partials.karpim-print-styles')
</head>
<body>
    <div class="print-toolbar">
        <a href="{{ url()->previous() }}">Kembali</a>
        <button type="button" onclick="window.print()">Cetak Data</button>
    </div>

    @include('pages.admin.partials.karpim-print-form', ['karyawan' => $karyawan])

    <script>
        window.onload = function () {
            window.print();
        };
    </script>
</body>
</html>
