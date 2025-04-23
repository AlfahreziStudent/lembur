<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class LaporanController extends Controller
{
    public function index(){
        $top = DB::table('users')
        ->select('users.name')
        ->where('users.id', '=', Auth::user()->id)
        ->first();

        return view('lembur/lembur/lembur',compact('top'));
    }
    public function detail($id){
        $top = DB::table('users')
        ->select('users.name')
        ->where('users.id', '=', Auth::user()->id)
        ->first();

        return view('lembur/lembur/detail',compact('top', 'id'));
    }

    public function datatable_lemburs(Request $request){
        if ($request->ajax()) {
            $data = Laporan::join('karyawans', 'laporans.id_karyawan', '=', 'karyawans.id')
            ->join('juduls', 'laporans.id_judul', '=', 'juduls.id')
            ->select(
                'juduls.id',
                'juduls.judul',
                DB::raw("COUNT(DISTINCT laporans.id_karyawan) AS total_karyawan")
            )
            ->groupBy('juduls.id', 'juduls.judul')
            ->orderBy('juduls.id', 'asc')
            ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editUrl = route('lembur-detail', ['id' => $row->id]);
                    $editBtn = '<a href="'.$editUrl.'" class="text-sm font-bold text-green-500 mr-3">Detail</a>';
                    return $editBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return response()->json(['message' => 'Invalid request'], 400);
    }

    public function datatable_lembur(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->input('id'); // Ambil id dari AJAX request

            $data = Laporan::join('karyawans', 'laporans.id_karyawan', '=', 'karyawans.id')
                ->join('juduls', 'laporans.id_judul', '=', 'juduls.id')
                ->join('kategoris', 'karyawans.kategori_karyawan', '=', 'kategoris.id')
                ->select(
                    'karyawans.nama_karyawan',
                    'juduls.id',
                    'juduls.judul',

                    // Total jam kerja hari kerja
                    DB::raw("SUM(CASE WHEN DAYOFWEEK(laporans.hari_lembur) NOT IN (1,7) THEN laporans.jam_kerja ELSE 0 END) AS total_jam_kerja_hari_kerja"),

                    // Total jam kerja hari libur
                    DB::raw("SUM(CASE WHEN DAYOFWEEK(laporans.hari_lembur) IN (1,7) THEN laporans.jam_kerja ELSE 0 END) AS total_jam_kerja_hari_libur"),

                    // Total jumlah makan
                    DB::raw("SUM(laporans.jml_makan) AS total_jml_makan"),

                    // Total biaya hari kerja
                    DB::raw("SUM(CASE WHEN DAYOFWEEK(laporans.hari_lembur) NOT IN (1,7) THEN laporans.jam_kerja * kategoris.biaya ELSE 0 END) AS total_biaya_hari_kerja"),

                    // Total biaya hari libur (biaya lembur 2x)
                    DB::raw("SUM(CASE WHEN DAYOFWEEK(laporans.hari_lembur) IN (1,7) THEN laporans.jam_kerja * (kategoris.biaya * 2) ELSE 0 END) AS total_biaya_hari_libur"),

                    // Total upah makan
                    DB::raw("SUM(laporans.jml_makan * kategoris.upah_makan) AS total_upah_makan"),

                    // Total keseluruhan
                    DB::raw("
                        SUM(
                            (CASE WHEN DAYOFWEEK(laporans.hari_lembur) NOT IN (1,7) THEN laporans.jam_kerja * kategoris.biaya ELSE 0 END) +
                            (CASE WHEN DAYOFWEEK(laporans.hari_lembur) IN (1,7) THEN laporans.jam_kerja * (kategoris.biaya * 2) ELSE 0 END) +
                            (laporans.jml_makan * kategoris.upah_makan)
                        ) AS total_keseluruhan
                    ")
                )
                ->where('juduls.id', $id) // Ambil data hanya untuk juduls.id yang dikirim dari AJAX
                ->groupBy('karyawans.nama_karyawan', 'juduls.id')
                ->orderBy('juduls.id', 'asc')
                ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->make(true);
        }

        return response()->json(['message' => 'Invalid request'], 400);
    }


}
