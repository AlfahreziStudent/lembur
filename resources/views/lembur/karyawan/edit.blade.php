@extends('lembur/layout/lembur')
@section('content_lembur')

<div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg mb-5">
    <div class="w-full">
        <h2 class="text-lg font-medium text-gray-900">
            Ubah Karyawan
        </h2>

        <form method="post" action="{{ route('update-karyawan',['id' => $data->id]) }}" class="mt-6 space-y-6">
            @csrf
            @method('patch')
            <div class="w-1/2">
                <x-input-label for="nama_karyawan" :value="__('Nama Karyawan')" />
                <x-text-input id="nama_karyawan" name="nama_karyawan" type="text" class="mt-1 block w-full" required autofocus autocomplete="nama_karyawan" value="{{ $data->nama_karyawan }}"/>
                <x-input-error class="mt-2" :messages="$errors->get('nama_karyawan')" />
            </div>


            <select id="kategori_karyawan" name="kategori_karyawan" class="input-field w-1/2" required autocomplete="kategori_karyawan">
                <option value="" disabled selected hidden>Pilih Kategori Karyawan</option>
                @foreach ($kategori as $k)
                    <option value="{{ $k->id }}" {{ $data->kategori_karyawan == $k->id ? 'selected' : '' }}>
                        {{ $k->nama_kategori }}
                    </option>
                @endforeach
            </select>

            <x-input-error class="mt-2" :messages="$errors->get('kategori_karyawan')" />
            <div class="flex items-start gap-4 w-1/2">
                <input type="submit" value="Submit" class="flex mt-3 justify-center items-center text-lg py-1 font-semibold rounded text-white bg-gradient-to-r from-cyan-300 to-violet-950 w-[75%]">
                <a href="{{ route('karyawan') }}" class="flex mt-3 justify-center items-center text-lg py-1 font-semibold rounded text-white bg-red-500 w-1/2">Cancel</a>
            </div>

@endsection
