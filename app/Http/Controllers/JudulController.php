<?php

namespace App\Http\Controllers;

use App\Models\Judul;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class JudulController extends Controller
{
    public function index(Request $request) {
        $top = DB::table('users')
        ->select('users.name')
        ->where('users.id', '=', Auth::user()->id)
        ->first();

        return view('lembur/judul/judul', compact('top'));
    }

    public function datatable_judul(Request $request){
        if ($request->ajax()) {
            $data = Judul::select('id', 'judul')->get(); // Tambahkan 'id'

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editUrl = route('edit-judul', ['id' => $row->id]);
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

        return view ('lembur/judul/create', compact('top'));
    }

    public function store(request $request){

        $request->validate([
            'judul' => ['required'],
        ]);
        $data['judul'] = $request->judul;

        Judul::create($data);

        return redirect('judul');
    }

    public function edit(request $request,$id){
        $top = DB::table('users')
        ->select('users.name')
        ->where('users.id', '=', Auth::user()->id)
        ->first();

        $data = Judul::find($id);

        return view('lembur/judul/edit',compact('data', 'top'));
    }

    public function update(request $request,$id) {
        $request->validate([
            'judul' => ['required'],
        ]);
        $data['judul'] = $request->judul;

        Judul::where('id', '=', $id)->update($data);

        return redirect('judul');
    }

    public function destroy($id) {
        $judul = Judul::find($id);

        if (!$judul) {
            return response()->json(['message' => 'Data tidak ditemukan!'], 404);
        }

        $judul->delete();
        return response()->json(['message' => 'Data berhasil dihapus!']);
    }
}
