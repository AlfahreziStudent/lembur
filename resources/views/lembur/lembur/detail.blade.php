@extends('lembur/layout/lembur')
@section('content_lembur')

<h1 class="font-bold text-slate-600 text-3xl">Laporan</h1>
<div class="flex  text-sm font-normal items-center mt-1">
    <a href="#" class="text-slate-500">home</a>
    <i data-feather="chevron-right" class="text-gray-400 font-bold"></i>
    <a href="#" class="text-slate-400">laporan</a>
</div>

{{-- Task --}}
<div class="garis mt-10 mb-3">
    <div class="bg-slate-100 pr-3 text-lg font-medium text-slate-600">Laporan</div>
</div>

<a href="{{ route('export-laporan',['id' => $id ]) }}" class="ml-auto shadow flex mb-5 mt-3 justify-center items-center text-sm py-3 font-semibold rounded text-white bg-green-500">CETAK LAPORAN
</a>

<div class="relative overflow-x-auto overflow-y-hidden">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 data-table shadow-md">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th class="px-6 py-3" scope="col">Nama Karyawan</th>
                <th class="py-3" scope="col">Judul</th>
                <th class="py-3" scope="col">Total Jumlah Makan</th>
                <th class="py-3" scope="col">Total Jam Kerja(hari kerja)</th>
                <th class="py-3" scope="col">Total Jam Kerja(hari libur)</th>
                <th class="py-3" scope="col">Total Upah Makan</th>
                <th class="py-3" scope="col">Total Gaji Lembur(hari kerja)</th>
                <th class="py-3" scope="col">Total Gaji Lembur(hari libur)</th>
                <th class="py-3" scope="col">Total Keseluruhan</th>
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>
</div>

<input type="hidden" id="id_judul" value="{{ $id }}">

<script type="text/javascript">

$(document).ready(function() {
    $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('table_lembur') }}",
            type: "GET",
            data: function(d) {
                d.id = $('#id_judul').val(); // Ambil ID dari elemen input hidden
            }
        },
        columns: [
            { data: 'nama_karyawan', name: 'nama_karyawan' },
            { data: 'judul', name: 'judul' },
            { data: 'total_jml_makan', name: 'total_jml_makan' },
            { data: 'total_jam_kerja_hari_kerja', name: 'total_jam_kerja_hari_kerja' },
            { data: 'total_jam_kerja_hari_libur', name: 'total_jam_kerja_hari_libur' },
            {
            data: 'total_upah_makan',
            name: 'total_upah_makan',
            render: function(data, type, row) {
                // Format total_biaya dengan Rp dan pemisah ribuan
                return 'Rp. ' + new Intl.NumberFormat('id-ID').format(data);
                }
            },
            {
            data: 'total_biaya_hari_kerja',
            name: 'total_biaya_hari_kerja',
            render: function(data, type, row) {
                // Format total_upah_makan dengan Rp dan pemisah ribuan
                return 'Rp. ' + new Intl.NumberFormat('id-ID').format(data);
                }
            },
            {
            data: 'total_biaya_hari_libur',
            name: 'total_biaya_hari_libur',
            render: function(data, type, row) {
                // Format total_keseluruhan dengan Rp dan pemisah ribuan
                return 'Rp. ' + new Intl.NumberFormat('id-ID').format(data);
                }
            },
            {
            data: 'total_keseluruhan',
            name: 'total_keseluruhan',
            render: function(data, type, row) {
                // Format total_keseluruhan dengan Rp dan pemisah ribuan
                return 'Rp. ' + new Intl.NumberFormat('id-ID').format(data);
                }
            }
        ],
        dom: '<"flex justify-between items-center mb-4"<"w-full flex justify-start space-x-4"f l>>rt<"flex justify-between items-center mt-4"ip>',
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
});
</script>
@endsection
