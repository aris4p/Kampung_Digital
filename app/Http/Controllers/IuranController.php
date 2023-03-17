<?php

namespace App\Http\Controllers;

use App\Models\Iuran;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class IuranController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
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

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        return view('Iuran.tambah',[
            'title' => "Transaksi"
        ]);
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        //
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show($id)
    {
        //
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit($id)
    {
        //
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
        //
    }

    public function payment(Request $request)
    {


        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = 'SB-Mid-server-lfUukJmI2f5bhEp7StcPwCOg';
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => rand(),
                'gross_amount' => 40000,
            ),
            'item_details'  => array(
                [
                    'id' => 'DANA-DANSOS',
                    'price'  =>  35000,
                    'quantity' => 10,
                    'name' => 'DANSOS',
                ],[
                    'id' => 'DANA-ZAKAT',
                    'price'  =>  80000,
                    'quantity' => 2,
                    'name' => 'Zakat',
                    ]
                ),
                'customer_details' => array(
                    'first_name' => 'budi',
                    'last_name' => 'pratama',
                    'email' => 'budi.pra@example.com',
                    'phone' => '08111222333',
                ),
            );

            $snapToken = \Midtrans\Snap::getSnapToken($params);

        }
    }
