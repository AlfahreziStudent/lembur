@extends('lembur/layout/lembur')
@section('content_lembur')

<h1 class="font-bold text-slate-600 text-3xl">Karyawan</h1>
<div class="flex  text-sm font-normal items-center mt-1">
    <a href="#" class="text-slate-500">home</a>
    <i data-feather="chevron-right" class="text-gray-400 font-bold"></i>
    <a href="#" class="text-slate-400">Karyawan</a>
</div>

{{-- Task --}}
<div class="garis mt-10 mb-3">
    <div class="bg-slate-100 pr-3 text-lg font-medium text-slate-600">Karyawan</div>
</div>

<a href="{{ route('buat-karyawan') }}" class="ml-auto shadow flex mb-5 mt-3 justify-center items-center text-sm py-3 font-semibold rounded text-white bg-green-500">
    <i data-feather="plus" width="24px" height="24px" class="mr-1"></i> TAMBAH KARYAWAN
</a>

<div class="relative ">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 data-table overflow-x-auto shadow-md">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th class="px-6 py-3" scope="col">Nama karyawan</th>
                <th class="py-3" scope="col">Kategori</th>
                <th class="py-3" scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $d)
            <tr class="">
                <th scope="row" class="">
                    {{ $d->nama_karyawan }}
                </th>
                <td class="px-6 py-4">
                    Rp. {{ $d->nama_kategori }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>



<script type="text/javascript">
$(document).ready(function() {
    $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('table_karyawan') }}",
        columns: [
            { data: 'nama_karyawan', name: 'nama_karyawan' },
            { data: 'nama_kategori', name: 'nama_kategori' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        dom: '<"flex justify-between items-center mb-4"lf>rt<"flex justify-between items-center mt-4"ip>',
        language: {
            lengthMenu: "",
            search: "", // Hapus tulisan "Search"
            searchPlaceholder: "Search", // Tambahkan placeholder
            lengthMenu: "Tampilkan _MENU_ data"  // Ganti "Show _MENU_ entries"
        },
        drawCallback: function() {
            // Styling untuk search box
            $('.dataTables_filter input')
                .addClass('block pt-2 ps-3 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500');

            // Styling untuk dropdown jumlah entri
            $('.dataTables_length select')
                .addClass('w-16 border border-gray-300 rounded-md px-2 py-1 text-sm');

            // Styling untuk pagination
            $('.dataTables_paginate .paginate_button')
                .addClass('border text-sm border-gray-300 px-3 py-2 rounded-md bg-white hover:bg-gray-300 text-gray-500 cursor-pointer mx-1 transition duration-200');

            // Styling tombol pagination aktif
            $('.dataTables_paginate .paginate_button.current')
                .addClass('bg-blue-500 text-gray-300 font-semibold text-sm');

            // Styling info jumlah data
            $('.dataTables_info')
                .addClass('text-gray-600 text-sm');
            $('.dataTables_length label').contents().filter(function() {
                return this.nodeType === 3;
            }).remove();
            $('.data-table tbody tr').each(function() {
                $(this).addClass('bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600'); // Styling tambahan
            });
            $('.data-table tbody td:nth-child(1)').each(function() {
                $(this).addClass('px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white'); // Tambahkan background dan tengah-kan teks
            });
            $('.data-table tbody td:nth-child(3)').each(function() {
                $(this).addClass('flex py-4'); // Tambahkan background dan tengah-kan teks
            });
        }
    });

    $(document).on('click', '.delete-btn', function() {
        var id = $(this).data('id');

        Swal.fire({
            title: "Apakah Anda yakin?",
            text: "Data yang dihapus tidak bisa dikembalikan!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Ya, hapus!",
            cancelButtonText: "Batal"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('delete-karyawan', '') }}/" + id,
                    type: "DELETE",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        Swal.fire({
                        title: "Terhapus!",
                        text: "Data berhasil dihapus.",
                        icon: "success",
                        confirmButtonText: "OK"
                    }).then(() => {
                        location.reload(); // RELOAD SETELAH OK DITEKAN
                    });
                    },
                    error: function() {
                        Swal.fire("Oops!", "Terjadi kesalahan saat menghapus.", "error");
                    }
                });
            }
        });
    });
});
</script>
@endsection
