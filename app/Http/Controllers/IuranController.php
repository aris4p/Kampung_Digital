<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IuranController extends Controller
{
    public function index()
    {
        return view('Iuran.index',[
            'title' => "Iuran Warga"
        ]);
    }
}
