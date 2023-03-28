<?php

namespace App\Http\Controllers;

use App\Models\Dana;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DanaController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index(Request $request)
    {
        $dana = Dana::all();

        if ($request->ajax()) {
            return Datatables::of($dana)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                //kita tambahkan button edit dan hapus
                $btn = '<a href="javascript:void(0)" data-id="' . $row->id . '" class="edit btn btn-primary btn-sm editKategori"><i class="fa fa-edit"></i>Edit</a>';

                $btn = $btn . ' <a href="javascript:void(0)" data-id="' . $row->id . '" class="btn btn-danger btn-sm deleteKategori"><i class="fa fa-trash"></i>Delete</a>';

                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }

        return view('Iuran.Dana.index',[
            'title' => "Dana Iuran"
        ],
        compact('dana'));

        // return view('Iuran.danaiuran',[
            //     'title' => "Dana Iuran",
            //     'dana' => $dana
            // ]);

        }

        /**
        * Show the form for creating a new resource.
        *
        * @return \Illuminate\Http\Response
        */
        public function create(Request $request)
        {

        }

        /**
        * Store a newly created resource in storage.
        *
        * @param  \Illuminate\Http\Request  $request
        * @return \Illuminate\Http\Response
        */
        public function store(Request $request)
        {
            //kita gunakan laravel laravel eloquent untuk update dan create agar lebih mudah
            //jadi jika request ada id maka akan melakukan update
            Dana::updateOrCreate(
                ['id' => $request->id],
                [
                    'nama' => $request->name,
                    'nominal' => $request->nominal
                    ]
                );

                return response()->json(['success' => 'Dana saved successfully.']);
            }

            /**
            * Display the specified resource.
            *
            * @param  int  $id
            * @return \Illuminate\Http\Response
            */
            public function show($id)
            {

            }

            /**
            * Show the form for editing the specified resource.
            *
            * @param  int  $id
            * @return \Illuminate\Http\Response
            */
            public function edit($id)
            {
                //mengambil data sesuai id
                $dana = Dana::find($id);
                return response()->json($dana);
            }

            /**
            * Update the specified resource in storage.
            *
            * @param  \Illuminate\Http\Request  $request
            * @param  int  $id
            * @return \Illuminate\Http\Response
            */
            public function update(Request $request, $id)
            {
                //
            }

            /**
            * Remove the specified resource from storage.
            *
            * @param  int  $id
            * @return \Illuminate\Http\Response
            */
            public function destroy($id)
            {
                //delete sow
                Dana::find($id)->delete();
                return response()->json(['success'=>'Dana deleted successfully.']);

            }

        }
