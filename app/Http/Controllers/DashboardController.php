<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $warga = Warga::count();
        return view('dashboard.index',[ 'title' => 'Dashboard']
                    ,compact('warga')
        );
    }


}
