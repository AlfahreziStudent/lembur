@extends('lembur/layout/lembur')
@section('content_lembur')

<div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg mb-5">
    <div class="w-full">
        <h2 class="text-lg font-medium text-gray-900">
            Tambah Laporan
        </h2>

        <form method="post" action="{{ route('tambah-laporan') }}" class="mt-6 space-y-6">
            @csrf
            <div class="w-1/2">
                <label for="id_karyawan" class="block text-sm font-medium text-gray-700">Nama Karyawan</label>
                <select id="id_karyawan" name="id_karyawan" class="input-field w-full select2" required>
                    <option disabled selected hidden>Cari Karyawan</option>
                    @foreach ( $data as $d )
                    <option value="{{ $d->id }}" class="select">{{ $d->nama_karyawan }}</option>
                    @endforeach
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('id_karyawan')" />
            </div>
            <div class="w-1/2">
                <label for="id_judul" class="block text-sm font-medium text-gray-700">Judul</label>
                <select id="id_judul" name="id_judul" class="input-field w-full select2" required>
                    <option disabled selected hidden>Cari Judul</option>
                    @foreach ( $judul as $j )
                    <option value="{{ $j->id }}" class="select">{{ $j->judul }}</option>
                    @endforeach
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('id_karyawan')" />
            </div>

            <div class="w-1/2">
                <x-input-label for="hari_lembur" :value="__('Hari Lembur')" />
                <x-text-input id="hari_lembur" name="hari_lembur" type="date" class="mt-1 block w-full" required autocomplete="hari_lembur" />
                <x-input-error class="mt-2" :messages="$errors->get('hari_lembur')" />
            </div>

            <div class="w-1/2">
                <x-input-label for="jam_kerja" :value="__('Jam kerja/Hari')" />
                <x-text-input id="jam_kerja" name="jam_kerja" type="text" class="mt-1 block w-full" required autofocus autocomplete="jam_kerja" placeholder="Ex. 1"/>
                <x-input-error class="mt-2" :messages="$errors->get('jam_kerja')" />
            </div>

            <div class="w-1/2">
                <x-input-label for="jml_makan" :value="__('Jumlah Makan')" />
                <x-text-input id="jml_makan" name="jml_makan" type="text" class="mt-1 block w-full" required autofocus autocomplete="jml_makan" placeholder="Ex. 1"/>
                <x-input-error class="mt-2" :messages="$errors->get('jml_makan')" />
            </div>


            <div class="flex items-start gap-4 w-1/2">
                <input type="submit" value="Submit" class="flex mt-3 justify-center items-center text-lg py-1 font-semibold rounded text-white bg-gradient-to-r from-cyan-300 to-violet-950 w-[75%]">
                <a href="{{ route('laporan') }}" class="flex mt-3 justify-center items-center text-lg py-1 font-semibold rounded text-white bg-red-500 w-1/2">Cancel</a>
            </div>

            <script>
                $(document).ready(function() {
                    $('#id_karyawan').select2({
                        placeholder: "Cari Karyawan...",
                        allowClear: true
                    });
                });
            </script>
            <script>
                $(document).ready(function() {
                    $('#id_judul').select2({
                        placeholder: "Cari Judul...",
                        allowClear: true
                    });
                });
            </script>

@endsection
