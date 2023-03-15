<?php

namespace App\Http\Controllers;

use App\Models\Iuran;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;


class IuranController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $iuran = Iuran::latest();
            return DataTables::of($iuran)
                ->addIndexColumn()
                ->editColumn('statustrx', function($iuran){
                    if ($iuran->statustrx == 0) return '<div class="btn btn-sm btn-warning">Belum Lunas</div>';
                    return '<div class="btn btn-sm btn-danger">Lunas</div>';
                })
                ->rawColumns(['statustrx'])
                ->make(true);
        }


        return view('Iuran.index',[
            'title' => "Iuran Warga"
        ]);
    }
}
