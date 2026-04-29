@extends('layouts.app')

@section('content')
    <x-common.page-breadcrumb pageTitle="Data Karyawan" />
    
    <div class="space-y-6">
        <x-common.component-card title="Daftar Karyawan Terdaftar">
            
            <x-tables.basic-tables.basic-tables-two :karyawans="$karyawans" />
            
        </x-common.component-card>
    </div>
@endsection