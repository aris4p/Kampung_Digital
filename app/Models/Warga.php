<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Warga extends Model
{
    protected $fillable = [
        'nama','nik','tglLahir','provinsi_id','kota_id','kecamatan_id','kelurahan_id','alamat','jeniskelamin','nohp','image'
    ];

    // public function gettglLahirAttribute()
    // {
    //     return Carbon::parse($this->attributes['tglLahir'])
    //                     ->translatedFormat('l, d F Y');
    // }

    // protected $dates = ['tglLahir'];

    function province(){
        return $this->belongsTo(Province::class, 'provinsi_id','id');
    }
    function regency(){
        return $this->belongsTo(Regency::class, 'kota_id','id');
    }
    function district(){
        return $this->belongsTo(District::class, 'kecamatan_id','id');
    }
    function village(){
        return $this->belongsTo(Village::class, 'kelurahan_id','id');
    }
}
