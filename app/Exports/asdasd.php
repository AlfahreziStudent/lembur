<?php

namespace App\Exports;

use App\Models\Laporan;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class LaporanExcel implements FromCollection, WithHeadings, WithMapping, WithEvents
{
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function collection()
    {
        return Laporan::join('karyawans', 'laporans.id_karyawan', '=', 'karyawans.id')
            ->join('juduls', 'laporans.id_judul', '=', 'juduls.id')
            ->join('kategoris', 'karyawans.kategori_karyawan', '=', 'kategoris.id')
            ->select(
                'karyawans.id as karyawan_id',
                'karyawans.nama_karyawan',
                'juduls.judul',
                'kategoris.biaya',
                'kategoris.upah_makan',
                DB::raw("MAX(laporans.hari_lembur) AS hari_lembur_terakhir"),

                DB::raw("SUM(CASE WHEN DAYOFWEEK(laporans.hari_lembur) NOT IN (1,7) THEN laporans.jam_kerja ELSE 0 END) AS total_jam_kerja_hari_kerja"),
                DB::raw("SUM(CASE WHEN DAYOFWEEK(laporans.hari_lembur) IN (1,7) THEN laporans.jam_kerja ELSE 0 END) AS total_jam_kerja_hari_libur"),
                DB::raw("SUM(laporans.jml_makan) AS total_jml_makan"),
                DB::raw("SUM(laporans.jml_makan * kategoris.upah_makan) AS total_upah_makan"),

                DB::raw("
                    SUM(
                        (CASE WHEN DAYOFWEEK(laporans.hari_lembur) NOT IN (1,7) THEN laporans.jam_kerja * kategoris.biaya ELSE 0 END) +
                        (CASE WHEN DAYOFWEEK(laporans.hari_lembur) IN (1,7) THEN laporans.jam_kerja * (kategoris.biaya * 2) ELSE 0 END) +
                        (laporans.jml_makan * kategoris.upah_makan)
                    ) AS total_keseluruhan
                ")
            )
            ->where('juduls.id', $this->id)
            ->groupBy('karyawans.nama_karyawan', 'juduls.id')
            ->orderBy('juduls.id', 'asc')
            ->get();
    }

    public function headings(): array
    {
        return [
            ["Nama Karyawan", "Judul", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", "", 'Jumlah Jam', '', 'Jml Makan Lembur', 'Uang Lembur', 'Uang Makan', 'Jumlah Kotor', 'PPH', 'Jumlah Bersih'],
            array_merge(["", "", "Hari Kerja", "Hari Libur"], range(1, 16)),
            array_merge(["", "", "", ""], range(17, 31), [""])
        ];
    }

    public function map($row): array
    {
        // Inisialisasi array untuk tanggal 1-31 dengan nilai default 0
        $jamPerTanggal = array_fill(1, 31, 0);

        // Ambil data jam kerja berdasarkan tanggalnya
        $data = Laporan::where('id_karyawan', $row->karyawan_id)
            ->whereMonth('hari_lembur', date('m', strtotime($row->hari_lembur_terakhir)))
            ->whereYear('hari_lembur', date('Y', strtotime($row->hari_lembur_terakhir)))
            ->where('id_judul', '=', $this->id)
            ->get();

        foreach ($data as $item) {
            $tanggal = (int)date('j', strtotime($item->hari_lembur)); // Ambil angka tanggal
            if ($tanggal >= 1 && $tanggal <= 31) {
                $jamPerTanggal[$tanggal] += $item->jam_kerja; // Tambahkan jumlah jam kerja
            }
        }

        // Pisahkan jam kerja ke dalam dua bagian
        $jamTanggal1_16 = array_slice($jamPerTanggal, 0, 16); // Tanggal 1-16
        $jamTanggal17_31 = array_slice($jamPerTanggal, 16, 15); // Tanggal 17-31

        // Baris pertama (Tanggal 1-16)
        $firstRow = array_merge([
            $row->nama_karyawan,
            $row->judul,
            $row->total_jam_kerja_hari_kerja,
            $row->total_jam_kerja_hari_libur,
        ], $jamTanggal1_16, [
            $row->total_jml_makan,
            $row->biaya,
            $row->upah_makan,
            $row->total_keseluruhan, // Uang lembur
            $row->pph ?? 0,
            $row->total_keseluruhan,
        ]);

        // Baris kedua (Tanggal 17-31, kosongkan nama & judul biar lebih rapi)
        $secondRow = array_merge([
            "", // Kosongkan nama
            "", // Kosongkan judul
            "", // Kosongkan hari kerja
            "", // Kosongkan hari libur
        ], $jamTanggal17_31
    );

        return [$firstRow, $secondRow]; // Kembalikan dalam format array untuk menampilkan 2 baris per karyawan
    }


    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet;

                $sheet->mergeCells('C1:D1');
                $sheet->setCellValue('C1', 'Jumlah Jam');
                // Merge header "Jumlah Jam Kerja Pada Bulan:"
                $sheet->mergeCells("E1:T1");
                $sheet->setCellValue('E1', 'Jumlah Jam Kerja Pada Bulan:');

                // Merge header lainnya
                $sheet->mergeCells("A1:A3");
                $sheet->mergeCells("B1:B3");
                $sheet->mergeCells("C2:C3");
                $sheet->mergeCells("D2:D3");
                $sheet->mergeCells("U1:U3");
                $sheet->mergeCells("V1:V3");
                $sheet->mergeCells("W1:W3");
                $sheet->mergeCells("X1:X3");
                $sheet->mergeCells("Y1:Y3");
                $sheet->mergeCells("Z1:Z3");

                // Style header
                $sheet->getStyle("A1:Z3")->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
                ]);

                // Border semua sel
                $highestRow = $sheet->getHighestRow();

                for ($row = 4; $row <= $highestRow; $row += 2) { // Mulai dari baris 4 setelah header
                    $sheet->mergeCells("A{$row}:A" . ($row + 1));
                    $sheet->mergeCells("B{$row}:B" . ($row + 1));
                    $sheet->mergeCells("C{$row}:C" . ($row + 1));
                    $sheet->mergeCells("D{$row}:D" . ($row + 1));
                    $sheet->mergeCells("U{$row}:U" . ($row + 1));
                    $sheet->mergeCells("V{$row}:V" . ($row + 1));
                    $sheet->mergeCells("W{$row}:W" . ($row + 1));
                    $sheet->mergeCells("X{$row}:X" . ($row + 1));
                    $sheet->mergeCells("Y{$row}:Y" . ($row + 1));
                    $sheet->mergeCells("Z{$row}:Z" . ($row + 1));
                }

                $highestColumn = $sheet->getHighestColumn();
                $sheet->getStyle("A1:" . $highestColumn . $highestRow)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
            }
        ];
    }
}
