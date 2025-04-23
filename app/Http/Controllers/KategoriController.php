<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class KategoriController extends Controller
{
    public function index(Request $request) {
        $top = DB::table('users')
        ->select('users.name')
        ->where('users.id', '=', Auth::user()->id)
        ->first();

        return view('lembur/kategori/kategori', compact('top'));
    }

    public function datatable_kategori(Request $request){
        if ($request->ajax()) {
            $data = Kategori::select('id', 'nama_kategori', 'biaya', 'upah_makan')->get(); // Tambahkan 'id'

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editUrl = route('edit-kategori', ['id' => $row->id]);
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

        return view ('lembur/kategori/create', compact('top'));
    }

    public function store(request $request){

        $request->validate([
            'nama_kategori' => ['required'],
            'biaya' => ['required'],
            'upah_makan' => ['required'],
        ]);
        $data['nama_kategori'] = $request->nama_kategori;
        $data['biaya'] = $request->biaya;
        $data['upah_makan'] = $request->upah_makan;

        Kategori::create($data);

        return redirect('kategori');
    }

    public function edit(request $request,$id){
        $top = DB::table('users')
        ->select('users.name')
        ->where('users.id', '=', Auth::user()->id)
        ->first();

        $data = Kategori::find($id);

        return view('lembur/kategori/edit',compact('data', 'top'));
    }

    public function update(request $request,$id) {
        $request->validate([
            'nama_kategori' => ['required'],
            'biaya' => ['required'],
            'upah_makan' => ['required'],
        ]);
        $data['nama_kategori'] = $request->nama_kategori;
        $data['biaya'] = $request->biaya;
        $data['upah_makan'] = $request->upah_makan;

        Kategori::where('id', '=', $id)->update($data);

        return redirect('kategori');
    }

    public function destroy($id) {
        $kategori = Kategori::find($id);

        if (!$kategori) {
            return response()->json(['message' => 'Data tidak ditemukan!'], 404);
        }

        $kategori->delete();
        return response()->json(['message' => 'Data berhasil dihapus!']);
    }

}
