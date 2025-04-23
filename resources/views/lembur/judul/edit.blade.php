@extends('lembur/layout/lembur')
@section('content_lembur')

<div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg mb-5">
    <div class="w-full">
        <h2 class="text-lg font-medium text-gray-900">
            Ubah Judul Laporan
        </h2>

        <form method="post" action="{{ route('update-judul',['id' => $data->id]) }}" class="mt-6 space-y-6">
            @csrf
            @method('put')
            <div class="w-1/2">
                <x-input-label for="judul" :value="__('Judul Laporan')" />
                <x-text-input id="judul" name="judul" type="text" class="mt-1 block w-full" required autofocus autocomplete="judul" value="{{ $data->judul }}"/>
                <x-input-error class="mt-2" :messages="$errors->get('judul')" />
            </div>

            <div class="flex items-start gap-4 w-1/2">
                <input type="submit" value="Submit" class="flex mt-3 justify-center items-center text-lg py-1 font-semibold rounded text-white bg-gradient-to-r from-cyan-300 to-violet-950 w-[75%]">
                <a href="{{ route('judul') }}" class="flex mt-3 justify-center items-center text-lg py-1 font-semibold rounded text-white bg-red-500 w-1/2">Cancel</a>
            </div>

@endsection
