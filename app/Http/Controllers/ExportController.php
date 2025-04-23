<?php

namespace App\Http\Controllers;

use App\Exports\LaporanExcel;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function export($id)
    {
        return Excel::download(new LaporanExcel($id), 'laporan.xlsx');
    }
}
