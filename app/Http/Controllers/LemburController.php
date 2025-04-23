<?php

namespace App\Http\Controllers;

use App\Models\Judul;
use App\Models\Laporan;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class LemburController extends Controller
{
    public function index(){
        $top = DB::table('users')
        ->select('users.name')
        ->where('users.id', '=', Auth::user()->id)
        ->first();

        return view('lembur/dashboard',compact('top'));
    }

    public function lembur(){
        $top = DB::table('users')
        ->select('users.name')
        ->where('users.id', '=', Auth::user()->id)
        ->first();

        return view('lembur/laporan/laporan',compact('top'));
    }

    public function datatable_laporan(Request $request){
        if ($request->ajax()) {
            $data = Laporan::join('karyawans', 'laporans.id_karyawan', '=', 'karyawans.id')
            ->select('laporans.id', 'laporans.hari_lembur', 'karyawans.nama_karyawan', 'laporans.jam_kerja', 'laporans.jml_makan')
            ->get(); // Tambahkan 'id'

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editUrl = route('edit-laporan', ['id' => $row->id]);
                    $editBtn = '<a href="'.$editUrl.'" class="text-sm font-bold text-green-500 mr-3">Edit</a>';
                    $deleteBtn = '<button class="delete-btn text-sm font-bold text-red-500" data-id="'.$row->id.'">Delete</button>';
                    return $editBtn . $deleteBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return response()->json(['message' => 'Invalid request'], 400);
    }

    public function create(){
        $top = DB::table('users')
        ->select('users.name')
        ->where('users.id', '=', Auth::user()->id)
        ->first();

        $data = Karyawan::select('id', 'nama_karyawan')
        ->get();
        $judul = Judul::select('id', 'judul')
        ->get();

        return view ('lembur/laporan/create', compact('top', 'data', 'judul'));
    }

    public function store(request $request){

        $request->validate([
            'id_karyawan' => ['required'],
            'id_judul' => ['required'],
            'hari_lembur' => ['required'],
            'jam_kerja' => ['required'],
            'jml_makan' => ['required'],
        ]);
        $data['id_karyawan'] = $request->id_karyawan;
        $data['id_judul'] = $request->id_judul;
        $data['hari_lembur'] = $request->hari_lembur;
        $data['jam_kerja'] = $request->jam_kerja;
        $data['jml_makan'] = $request->jml_makan;

        Laporan::create($data);

        return redirect('laporan');
    }

    public function edit(request $request,$id){
        $top = DB::table('users')
        ->select('users.name')
        ->where('users.id', '=', Auth::user()->id)
        ->first();

        $data = Laporan::join('karyawans', 'laporans.id_karyawan', '=', 'karyawans.id')
        ->join('juduls', 'laporans.id_judul', '=', 'juduls.id')
        ->select('laporans.id', 'laporans.hari_lembur', 'karyawans.nama_karyawan', 'laporans.jam_kerja', 'laporans.id_karyawan', 'laporans.jml_makan', 'laporans.id_judul')
        ->where('laporans.id', '=', $id)
        ->first();

        $karyawan = Karyawan::select('id', 'nama_karyawan')
        ->get();

        $judul = Judul::select('id', 'judul')
        ->get();

        return view('lembur/laporan/edit',compact('data', 'top', 'karyawan', 'judul'));
    }

    public function update(request $request,$id) {
        $request->validate([
            'id_karyawan' => ['required'],
            'id_judul' => ['required'],
            'hari_lembur' => ['required'],
            'jam_kerja' => ['required'],
            'jml_makan' => ['required'],
        ]);
        $data['id_karyawan'] = $request->id_karyawan;
        $data['id_judul'] = $request->id_judul;
        $data['hari_lembur'] = $request->hari_lembur;
        $data['jam_kerja'] = $request->jam_kerja;
        $data['jml_makan'] = $request->jml_makan;

        Laporan::where('id', '=', $id)->update($data);

        return redirect('laporan');
    }

    public function destroy($id) {
        $laporan = Laporan::find($id);

        if (!$laporan) {
            return response()->json(['message' => 'Data tidak ditemukan!'], 404);
        }

        $laporan->delete();
        return response()->json(['message' => 'Data berhasil dihapus!']);
    }
}
