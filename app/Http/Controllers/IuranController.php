<?php

namespace App\Http\Controllers;

use App\Models\Iuran;
use App\Models\Warga;
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
                if ($iuran->statustrx == 'pending') return '<div class="btn btn-sm btn-warning">Belum Lunas</div>';
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

        // $warga = Warga::where('nik', $request->id_nik )->first();
        // dd($warga->nama);


        $request->request->add(['idtrx'=> 'TRX-'.date('Ymdh').rand('10','9999')]);
        // dd($request->all());
        $payment = $request->all();
        $iuran = Warga::where('nik', $request->id_nik)->first();

        // dd($iuran);
        // dd($request->idtrx);
        // dd($payment->idtrx);



        // dd($payment);
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        $params = array(
            'transaction_details' => array(
                'order_id' => $request->idtrx,
                'gross_amount' => $request->nominaltrx,
            ),
            'item_details'  => array(
                [
                    'id' => 'DNS-788',
                    'price'  =>  $request->nominaltrx,
                    'quantity' => 1,
                    'name' => $request->jenistrx,
                    ]
                ),
                'customer_details' => array(
                    'first_name' => $iuran->nama,
                    'last_name' =>  '',
                    'email' => 'arisanggara72@gmail.com',
                    'phone' =>  $iuran->nohp,
                ),
            );
            // dd($params);
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            $parameter = json_decode(json_encode($params, true));
            // dd($parameter);
            return view('Iuran.payment',[
                'title' => "Transaksi",
                'snaptoken' => $snapToken,
                'request' => $request,

                'parameter' => $parameter,
            ]);

        }

        public function payment_post(Request $request)
        {
            $json = json_decode($request->get('json'));



            $data = [
                'idtrx' => $json->order_id,
                'id_nik' => $request->get('id_nik'),
                'jenistrx' => $request->get('jenistrx'),
                'nominaltrx' => $request->get('nominaltrx'),
                'statustrx' => $json->transaction_status,
            ];

            return Iuran::create($data) ? redirect(route('iuran'))->with('alert-success', 'Transaksi Berhasil dibuat') : redirect(route('iuran'))->with('alert-failed', 'Error Terjadi kesalahan');


        }
    }



