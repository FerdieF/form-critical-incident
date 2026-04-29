<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Form Karpim Semua Peserta</title>
    @include('pages.admin.partials.karpim-print-styles')
</head>
<body>
    @foreach($users as $user)
        @if($user->karyawan)
            @include('pages.admin.partials.karpim-print-form', ['karyawan' => $user->karyawan])
        @else
            <section class="sheet">
                <div class="brand-header">
                    <img src="{{ asset('images/logo-ptpn4.png') }}" alt="Logo PTPN4">
                    <div class="brand-title">
                        PT Perkebunan Nusantara IV
                        <span>Regional I</span>
                    </div>
                    <div class="form-code">FDP -</div>
                </div>
                <div class="form-title">FORMULIR DATA PRIBADI</div>
                <p>Karyawan <strong>{{ $user->name }}</strong> belum mengisi form asesmen.</p>
            </section>
        @endif
    @endforeach

    <script>
        window.onload = function () {
            window.print();
        };
    </script>
</body>
</html>
