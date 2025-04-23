@extends('lembur/layout/lembur')
@section('content_lembur')

<div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg mb-5">
    <div class="w-full">
        <h2 class="text-lg font-medium text-gray-900">
            Ubah Kategori
        </h2>

        <form method="post" action="{{ route('update-kategori',['id' => $data->id]) }}" class="mt-6 space-y-6">
            @csrf
            @method('PUT')
            <div class="w-1/2">
                <x-input-label for="nama_kategori" :value="__('Nama kategori')" />
                <x-text-input id="nama_kategori" name="nama_kategori" type="text" class="mt-1 block w-full" required autofocus autocomplete="nama_kategori" value="{{ $data->nama_kategori }}"/>
                <x-input-error class="mt-2" :messages="$errors->get('nama_kategori')" />
            </div>

            <div class="w-1/2">
                <x-input-label for="biaya" :value="__('Biaya Perjam')" />
                <x-text-input id="biaya" name="biaya" type="text" class="mt-1 block w-full" required autofocus autocomplete="biaya" value="{{ $data->biaya }}"/>
                <x-input-error class="mt-2" :messages="$errors->get('biaya')" />
            </div>

            <div class="w-1/2">
                <x-input-label for="upah_makan" :value="__('Upah Makan')" />
                <x-text-input id="upah_makan" name="upah_makan" type="text" class="mt-1 block w-full" required autofocus autocomplete="upah_makan" value="{{ $data->upah_makan }}"/>
                <x-input-error class="mt-2" :messages="$errors->get('upah_makan')" />
            </div>

            <div class="flex items-start gap-4 w-1/2">
                <input type="submit" value="Submit" class="flex mt-3 justify-center items-center text-lg py-1 font-semibold rounded text-white bg-gradient-to-r from-cyan-300 to-violet-950 w-[75%]">
                <a href="{{ route('kategori') }}" class="flex mt-3 justify-center items-center text-lg py-1 font-semibold rounded text-white bg-red-500 w-1/2">Cancel</a>
            </div>
@endsection
