<?php

namespace App\Http\Controllers;

use App\Models\Iuran;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function payment_handler(Request $request)
    {
        $json = json_decode($request->getContent());
        $signatureKey = hash('sha512', $json->order_id . $json->status_code . $json->gross_amount . env('MIDTRANS_SERVER_KEY'));

        if ($signatureKey != $json->signature_key){
            return  abort(404);
        }
        //status confirmed
        $iuran = Iuran::where('idtrx' , $json->order_id)->first();
        return $iuran->update(['statustrx' => $json->transaction_status]);
        // if ($json->status_code == '200'){


        // }

        // // $iuran = Iuran::where('idtrx' , $json->order_id)->first();
        // // return $iuran->update(['snap_token' => null]);

    }
}
