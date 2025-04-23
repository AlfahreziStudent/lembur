<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class KaryawanController extends Controller
{
    public function index() {
        $top = DB::table('users')
        ->select('users.name')
        ->where('users.id', '=', Auth::user()->id)
        ->first();

        $data = Karyawan::join('kategoris', 'karyawans.kategori_karyawan', '=', 'kategoris.id')
        ->select('karyawans.id', 'karyawans.nama_karyawan', 'kategoris.nama_kategori')
        ->get();

        return view('lembur/karyawan/karyawan', compact('top','data'));
    }

    public function datatable_karyawan(Request $request){
        if ($request->ajax()) {
            $data = Karyawan::join('kategoris', 'karyawans.kategori_karyawan', '=', 'kategoris.id')
            ->select('karyawans.id', 'karyawans.nama_karyawan', 'kategoris.nama_kategori')
            ->get(); // Tambahkan 'id'

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editUrl = route('edit-karyawan', ['id' => $row->id]);
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

        $data = Kategori::select('id', 'nama_kategori')
        ->get();

        return view ('lembur/karyawan/create', compact('top', 'data'));
    }

    public function store(request $request){

        $request->validate([
            'nama_karyawan' => ['required'],
            'kategori_karyawan' => ['required'],
        ]);
        $data['nama_karyawan'] = $request->nama_karyawan;
        $data['kategori_karyawan'] = $request->kategori_karyawan;

        Karyawan::create($data);

        return redirect('karyawan');
    }

    public function edit(request $request,$id){
        $top = DB::table('users')
        ->select('users.name')
        ->where('users.id', '=', Auth::user()->id)
        ->first();

        $kategori = Kategori::select('id', 'nama_kategori')
        ->get();
        $data = Karyawan::join('kategoris', 'karyawans.kategori_karyawan', '=', 'kategoris.id')
        ->select('karyawans.id', 'karyawans.nama_karyawan', 'kategoris.nama_kategori', 'kategori_karyawan')
        ->where('karyawans.id', '=', $id)
        ->first();
        return view('lembur/karyawan/edit',compact('data', 'top', 'kategori'));
    }

    public function update(request $request,$id) {
        $request->validate([
            'nama_karyawan' => ['required'],
            'kategori_karyawan' => ['required'],
        ]);
        $data['nama_karyawan'] = $request->nama_karyawan;
        $data['kategori_karyawan'] = $request->kategori_karyawan;

        Karyawan::where('id', '=', $id)->update($data);

        return redirect('karyawan');
    }

    public function destroy($id) {
        $karyawan = Karyawan::find($id);

        if (!$karyawan) {
            return response()->json(['message' => 'Data tidak ditemukan!'], 404);
        }

        $karyawan->delete();
        return response()->json(['message' => 'Data berhasil dihapus!']);
    }
}
