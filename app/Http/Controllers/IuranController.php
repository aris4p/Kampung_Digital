<?php

namespace App\Http\Controllers;

use App\Models\Dana;
use App\Models\Iuran;
use App\Models\Warga;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Services\Midtrans\CreateSnapTokenService;

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
            $iuran = Iuran::with('dana')->latest();
            return DataTables::of($iuran)
            ->addIndexColumn()
            ->editColumn('statustrx', function($iuran){
                if ($iuran->statustrx == 'settlement')
                return '<div class="btn btn-sm btn-success">Lunas</div>';
                return '<a href="'. route('lihat-data',  ['id'=>$iuran->idtrx]) .'" class="btn btn-warning">Lihat</a>';
            })
            ->editColumn('jenistrx_id', function($iuran){
                return ($iuran->dana->nama);

            })
            ->rawColumns(['statustrx'])
            ->make(true);
        }
        // $iuran = Iuran::with('dana')->where('jenistrx_id', '9')->first();
        // dd($iuran->dana);

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


        $request->request->add(['idtrx'=> 'TRX-'.date('Ymdh').rand('10','9999'), 'statustrx' => 'pending']);

        $dana = Dana::find($request->jenistrx_id);
        $warga = Warga::where('nik', $request->id_nik)->first();
        // dd($warga->nama);



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
                    'id' => $dana->id,
                    'price'  => $dana->nominal,
                    'quantity' => 1,
                    'name' => $dana->nama,
                    ]
                ),
                'customer_details' => array(
                    'first_name' => $warga->nama,
                    'last_name' =>  '',
                    'email' => 'arisanggara72@gmail.com',
                    'phone' => $warga->nohp,
                ),
            );
            // dd($params);
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            // dd($snapToken);

            $data=[
                'idtrx' => $request->idtrx,
                'id_nik' => $request->id_nik,
                'jenistrx_id' => $request->jenistrx_id,
                'nominaltrx' => $request->nominaltrx,
                'statustrx' => $request->statustrx,
                'snap_token' => $snapToken
            ];

            return Iuran::create($data) ? redirect(route('iuran'))->with('alert-success', 'Transaksi Berhasil dibuat') : redirect(route('iuran'))->with('alert-failed', 'Error Terjadi kesalahan');;


        }

        /**
        * Display the specified resource.
        *
        * @param  int  $id
        * @return \Illuminate\Http\Response
        */
        public function show($id)
        {

            $payment = Iuran::with('warga','dana')->where('idtrx', $id)->first();
            // dd($payment->dana->nama);

            if(is_null($payment->snap_token)){
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
                        'order_id' => $payment->idtrx,
                        'gross_amount' => $payment->nominaltrx,
                    ),
                    'item_details'  => array(
                        [
                            'id' => $payment->jenistrx_id,
                            'price'  =>  $payment->nominaltrx,
                            'quantity' => 1,
                            'name' => $payment->dana->nama,
                            ]
                        ),
                        'customer_details' => array(
                            'first_name' => $payment->warga->nama,
                            'last_name' =>  '',
                            'email' => 'arisanggara72@gmail.com',
                            'phone' =>  $payment->warga->nohp,
                        ),
                    );
                    // dd($params);
                    $snapToken = \Midtrans\Snap::getSnapToken($params);
                    $payment->snap_token = $snapToken;
                    $payment->save();
                }
                // dd($payment);

                return view('Iuran.payment', compact('payment'));
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
                // $dana = Dana::find($id);
                // // ddd($dana);
                // $dana->delete();
                // return redirect(route('dana-iuran'))->with("Success","Dana telah dihapus!");
            }


            public function tambahdanaiuran(Request $request)
            {

                $request->validate([
                    'nama'  => 'required',
                    'nominal'  => 'required|numeric',

                ],[
                    'nama.required'=>'Nama Wajib Diisi',
                    'nominal.required'=>'Nominal Wajib Diisi',
                    'nominal.numeric'=>'Hanya Angka Diperbolehkan',


                ]);

                $data=[
                    'nama' => $request->input('nama'),
                    'nominal' => $request->input('nominal'),

                ];
                Dana::create($data);
                return redirect(route('dana-iuran'))->with('Success','Dana baru ditambahkan');
            }

            public function payment(Request $request)
            {

                // $warga = Warga::where('nik', $request->id_nik )->first();
                // dd($warga->nama);


                $request->request->add(['idtrx'=> 'TRX-'.date('Ymdh').rand('10','9999')]);
                // dd($request->all());
                $payment = $request->all();
                $iuran = Warga::where('nik', $request->id_nik)->first();

                if (is_null($iuran)) {

                    return redirect(route('iuran'))->with('alert-failed', 'Nik tidak Ditemukan');
                }

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


                public function getDana()
                {
                    $data = Dana::where('nama','LIKE','%'.request('q').'%')->paginate(10);;
                    return response()->json($data);

                }

                public function getDanaNominal($id)
                {
                    $data = Dana::where('id',$id)->where('nama','LIKE','%'.request('q').'%')->paginate(10);
                    return response()->json($data);

                }

                /* Gak dipake dulu

                public function payment_post(Request $request)
                {
                    $json = json_decode($request->get('json'));
                    return $json;


                    // $data = [
                        //     'idtrx' => $json->order_id,
                        //     'id_nik' => $request->get('id_nik'),
                        //     'jenistrx' => $request->get('jenistrx'),
                        //     'nominaltrx' => $request->get('gross_amount'),
                        //     'statustrx' => $json->transaction_status,
                        // ];

                        return DB::table('iurans')
                        ->updateOrInsert([
                            'idtrx' => $json->order_id,
                            'statustrx' => $json->transaction_status,
                            ]) ? redirect(route('iuran'))->with('alert-success', 'Transaksi Berhasil dibuat') : redirect(route('iuran'))->with('alert-failed', 'Error Terjadi kesalahan');


                        }

                        */
                    }



